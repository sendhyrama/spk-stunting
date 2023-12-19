<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaComp;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KriteriaCompController extends Controller
{
	private function getKriteriaPerbandingan()
	{
		try {
			return KriteriaComp::join(
				"kriteria",
				"kriteria_banding.kriteria1",
				"kriteria.id"
			)->select(
					"kriteria_banding.kriteria1 as idkriteria",
					"kriteria.id",
					"kriteria.name"
				)->groupBy("kriteria1", 'name')->get();
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal memuat hasil perbandingan:')
				->withErrors("Kesalahan SQLState #" . $e->errorInfo[0]);
		}
	}
	private function getPerbandinganByKriteria1($kriteria1)
	{
		try {
			return KriteriaComp::select('nilai', 'kriteria2', 'kriteria1')
				->where("kriteria2", $kriteria1)->get();
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal memuat hasil perbandingan:')
				->withErrors("Kesalahan SQLState #" . $e->errorInfo[0]);
		}
	}
	private function getNilaiPerbandingan($kode_kriteria)
	{
		try {
			return KriteriaComp::select("nilai", "kriteria1")
				->where("kriteria1", $kode_kriteria)->get();
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal memuat hasil perbandingan:')
				->withErrors("Kesalahan SQLState #" . $e->errorInfo[0]);
		}
	}
	public function index()
	{
		$crit = Kriteria::get();
		$jmlcrit = count($crit);
		$array = $value = [];
		$counter = 0;
		for ($a = 0; $a < $jmlcrit; $a++) {
			for ($b = $a; $b < $jmlcrit; $b++) {
				$array[$counter]["idbaris"] = $crit[$a]->id;
				$array[$counter]["namabaris"] = $crit[$a]->name;
				$array[$counter]["idkolom"] = $crit[$b]->id;
				$array[$counter]["namakolom"] = $crit[$b]->name;
				$value[$counter] = KriteriaComp::select('nilai')
					->where('kriteria1', $crit[$a]->id)
					->where('kriteria2', $crit[$b]->id)->firstOr(function () {
						return ['nilai' => 0]; //jika tidak ada
					});
				$counter++;
			}
		}
		$cek = KriteriaComp::count();
		return view('main.kriteria.comp', compact('array', 'cek', 'jmlcrit', 'value'));
	}
	public function simpan(Request $request)
	{
		$request->validate(KriteriaComp::$rules, KriteriaComp::$message);
		try {
			$kriteria = Kriteria::get();
			$a = 0;
			for ($i = 0; $i < count($kriteria); $i++) {
				for ($j = $i; $j < count($kriteria); $j++) {
					if ($kriteria[$i]->id === $kriteria[$j]->id)
						$nilai = 1;
					else {
						$nilai = $request->skala[$a];
						if ($request->kriteria[$a] === "right")
							$nilai = 0 - $request->skala[$a];
					}
					KriteriaComp::updateOrCreate(
						['kriteria1' => $kriteria[$i]->id, 'kriteria2' => $kriteria[$j]->id],
						['nilai' => $nilai]
					);
					$a++;
				}
			}
		} catch (QueryException $sql) {
			Log::error($sql);
			return back()->withInput()->withError('Gagal menyimpan nilai perbandingan:')
				->withErrors("Kesalahan SQLState #" . $sql->errorInfo[0]);
		}
		return to_route('bobotkriteria.result');
	}
	public function hasil()
	{
		if (KriteriaComp::count() === 0)
			return back()->withWarning('Perbandingan kriteria belum dilakukan');
		$kriteria = $this->getKriteriaPerbandingan();
		$a = 0;
		$matriks_perbandingan = $matriks_awal = [];
		foreach ($kriteria as $k) {
			$kode_kriteria = $k->idkriteria;
			$perbandingan = $this->getPerbandinganByKriteria1($kode_kriteria);
			if ($perbandingan) {
				foreach ($perbandingan as $hk) {
					if ($hk->kriteria2 !== $hk->kriteria1) {
						if ($hk->nilai < 0) {
							$nilai = abs($hk->nilai / 1);
							$nilai2 = "<sup>" . abs($hk->nilai) . "</sup>/<sub>1</sub>";
						} else {
							$nilai = abs(1 / $hk->nilai);
							$nilai2 = "<sup>1</sup>/<sub>" . abs($hk->nilai) . "</sub>";
						}
						$matriks_perbandingan[$a] = [
							"nilai" => $nilai,
							"kode_kriteria" => $kode_kriteria
						];
						$matriks_awal[$a] = [
							"nilai" => $nilai2,
							"kode_kriteria" => $kode_kriteria
						];
						$a++;
					}
				}
				$nilaiPerbandingan = $this->getNilaiPerbandingan($kode_kriteria);
				foreach ($nilaiPerbandingan as $hb) {
					if ($hb->nilai < 0) {
						$nilai = abs(1 / $hb->nilai);
						$nilai2 = "<sup>1</sup>/<sub>" . abs($hb->nilai) . "</sub>";
					} else {
						$nilai = abs(($hb->nilai > 1) ? $hb->nilai / 1 : $hb->nilai);
						$nilai2 = "<sup>" . abs($hb->nilai) . "</sup>/<sub>1</sub>";
					}
					$matriks_perbandingan[$a] = [
						"nilai" => $nilai,
						"kode_kriteria" => $kode_kriteria
					];
					$matriks_awal[$a] = [
						"nilai" => $nilai2,
						"kode_kriteria" => $kode_kriteria
					];
					$a++;
				}
			}
		}
		$array_jumlah = [];
		for ($j = 0; $j < count($kriteria); $j++) {
			$jumlah = 0;
			for ($i = $j; $i < count($matriks_perbandingan); $i += count($kriteria)) {
				$jumlah += $matriks_perbandingan[$i]["nilai"];
			}
			$array_jumlah[$j] = $jumlah;
		}
		$a = 0;
		$array_normalisasi = $array_filter = [];
		for ($i = 0; $i < count($kriteria); $i++) {
			for ($j = 0; $j < count($matriks_perbandingan); $j++) {
				if ($kriteria[$i]->idkriteria === $matriks_perbandingan[$j]["kode_kriteria"])
					$array_filter[] = $matriks_perbandingan[$j]["nilai"];
			}
			for ($k = 0; $k < count($matriks_perbandingan); $k++) {
				for ($m = 0; $m < count($array_filter); $m++) {
					$array_normalisasi[$a] = [
						"nilai" => $matriks_perbandingan[$a]['nilai'] / $array_jumlah[$m],
						"kode_kriteria" => $kriteria[$i]->idkriteria
					];
					$a++;
				}
				$array_filter = [];
			}
		}
		$total_jumlah_baris = 0;
		foreach ($array_normalisasi as $an) {
			$total_jumlah_baris += $an["nilai"];
		}
		$array_BobotPrioritas = [];
		$jumlah_baris = $index_kriteria = $j = 0;
		for ($i = 0; $i < count($array_normalisasi); $i++) {
			$jumlah_baris += $array_normalisasi[$i]["nilai"];
			if ($index_kriteria === count($kriteria) - 1) {
				$array_BobotPrioritas[$j] = [
					"jumlah_baris" => $jumlah_baris,
					"bobot" => $jumlah_baris / $total_jumlah_baris,
					"kode_kriteria" => $kriteria[$j]->idkriteria
				];
				$j++;
				$jumlah_baris = $index_kriteria = 0;
			} else
				$index_kriteria++;
		}
		$array_CM = [];
		$cm = $indexbobot = $j = 0;
		for ($i = 0; $i < count($matriks_perbandingan); $i++) {
			$cm += ($matriks_perbandingan[$i]["nilai"] *
				$array_BobotPrioritas[$indexbobot]["bobot"]);
			if ($indexbobot === count($kriteria) - 1) {
				$array_CM[$j] = [
					"cm" => $cm / $array_BobotPrioritas[$j]["bobot"],
					"kode_kriteria" => $kriteria[$j]->idkriteria,
					"kali_matriks" => $cm
				];
				$j++;
				$cm = $indexbobot = 0;
			} else
				$indexbobot++;
		}
		$total_cm = 0;
		foreach ($array_CM as $CM) {
			$total_cm += $CM["cm"];
		}
		$average_cm = $total_cm / count($array_CM);
		$total_ci = ($average_cm - count($array_CM)) / (count($array_CM) - 1);
		$ratio = Kriteria::$ratio_index[count($kriteria)];
		$result = $ratio === 0 ? '-' : $total_ci / $ratio;
		try {
			if ($result <= 0.1 || !is_numeric($result)) {
				for ($i = 0; $i < count($kriteria); $i++) {
					Kriteria::where("id", $kriteria[$i]->idkriteria)
						->update(["bobot" => $array_BobotPrioritas[$i]["bobot"]]);
				}
			} else
				Kriteria::where('bobot', '<>', 0.00000)->update(['bobot' => 0.00000]);
			$data = [
				"kriteria" => $kriteria,
				"matriks_perbandingan" => $matriks_perbandingan,
				"matriks_awal" => $matriks_awal,
				"average_cm" => $average_cm,
				"bobot_prioritas" => $array_BobotPrioritas,
				"matriks_normalisasi" => $array_normalisasi,
				"jumlah" => $array_jumlah,
				"cm" => $array_CM,
				"ci" => $total_ci,
				"result" => $result
			];
			return view('main.kriteria.hasil', compact('data'));
		} catch (QueryException $e) {
			Log::error($e);
			return back()->withError('Gagal memuat hasil perbandingan kriteria:')
				->withErrors("Kesalahan SQLState #" . $e->errorInfo[0]);
		}
	}
	public function destroy()
	{
		try {
			KriteriaComp::truncate();
			Kriteria::where('bobot', '<>', 0.00000)->update(['bobot' => 0.00000]);
			return to_route('bobotkriteria.index')
				->withSuccess('Perbandingan Kriteria sudah direset.');
		} catch (QueryException $sql) {
			Log::error($sql);
			return back()->withError('Perbandingan Kriteria gagal direset:')
				->withErrors("Kesalahan SQLState #" . $sql->errorInfo[0]);
		}
	}
}
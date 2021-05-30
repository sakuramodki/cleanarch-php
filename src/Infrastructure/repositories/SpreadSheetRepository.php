<?php


namespace App\Infrastructure\repositories;


use App\Domain\Model\Record;
use App\Domain\Repositories\RecordRepository;

class SpreadSheetRepository implements RecordRepository
{
    const CSV_PATH = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTWVH6vFIptjOhpNY5i9bsWHpYgCf2HjTjYeLKcLbyZexk83J2i1Ijte-SBPOXFF17lB6vglgzRKvI4/pub?output=csv";

    /**
     * @return Record[]
     */
    public function getRecords()
    {
        $releases = $this->getReleases();
        $recods = [];
        foreach ($releases as $release) {
            $recods[] = new Record(
                $release['Title'],
                $release['Link'],
                strtotime($release['Date'])
            );
        }

        return $recods;
    }

    /**
     * getReleases
     * Google Docsのcsvからリリース情報のArrayを取得する
     **/
    private function getReleases()
    {
        $csv = file_get_contents(self::CSV_PATH);
        $data = $this->filterCsv($csv);

        // csvからkey value形式へ変換する
        $releases = [];
        for ($i = 1; $i < count($data); $i++) {
            $release = [];
            foreach ((array)$data[0] as $index => $key) {
                $value = isset($data[$i][$index]) ? $data[$i][$index] : "";
                $value = preg_replace('/^"(.*)"$/', '\1', $value);
                $release[trim($key)] = trim($value);
            }
            $releases[] = $release;
        }
        return $releases;
    }

    /**
     * filterCsv
     * csv形式のStringをArrayに変換する
     * @param $csv string csv形式の文字列
     **/
    private function filterCsv($csv)
    {
        // csv filter
        $filtered = [];
        $cache = "";
        $lines = explode("\n", $csv);

        // "が閉じられていない場合次の行と連結する
        foreach ($lines as $line) {
            // 前回のループで"が閉じられてなければ改行文字で連結
            if ($cache !== "") {
                $cache .= "<br/>";
            }
            $cache .= $line;

            // "が偶数ならフィルタ済みにする
            $count = mb_substr_count($cache, '"');
            if ($count % 2 == 0) {
                $filtered[] = $cache;
                $cache = "";
            }
        }

        // 最終行が未処理ならフィルタ済みに突っ込む
        if ($cache !== "") {
            $filtered[] = $cache;
        }

        // 各行を,で分割
        $data = [];
        foreach ($filtered as $line) {
            $data[] = explode(",", $line);
        }

        return $data;
    }
}
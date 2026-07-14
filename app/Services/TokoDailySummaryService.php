<?php

namespace App\Services;

use App\Models\TokoDailySummary;

class TokoDailySummaryService
{
    /**
     * Store a new toko daily summary.
     *
     * @param array $data
     * @return \App\Models\TokoDailySummary
     */
    public function store(array $data)
    {
        return TokoDailySummary::create($data);
    }

    /**
     * Update an existing toko daily summary.
     *
     * @param \App\Models\TokoDailySummary $tokoDailySummary
     * @param array $data
     * @return \App\Models\TokoDailySummary
     */
    public function update(TokoDailySummary $tokoDailySummary, array $data)
    {
        $tokoDailySummary->update($data);
        return $tokoDailySummary;
    }

    /**
     * Delete a toko daily summary.
     *
     * @param \App\Models\TokoDailySummary $tokoDailySummary
     * @return bool|null
     */
    public function delete(TokoDailySummary $tokoDailySummary)
    {
        return $tokoDailySummary->delete();
    }
}

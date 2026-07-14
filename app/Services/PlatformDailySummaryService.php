<?php

namespace App\Services;

use App\Models\PlatformDailySummary;

class PlatformDailySummaryService
{
    /**
     * Store a new platform daily summary.
     *
     * @param array $data
     * @return \App\Models\PlatformDailySummary
     */
    public function store(array $data)
    {
        return PlatformDailySummary::create($data);
    }

    /**
     * Update an existing platform daily summary.
     *
     * @param \App\Models\PlatformDailySummary $platformDailySummary
     * @param array $data
     * @return \App\Models\PlatformDailySummary
     */
    public function update(PlatformDailySummary $platformDailySummary, array $data)
    {
        $platformDailySummary->update($data);
        return $platformDailySummary;
    }

    /**
     * Delete a platform daily summary.
     *
     * @param \App\Models\PlatformDailySummary $platformDailySummary
     * @return bool|null
     */
    public function delete(PlatformDailySummary $platformDailySummary)
    {
        return $platformDailySummary->delete();
    }
}

<?php

namespace Anticaptcha\Response;

final class GetAppStatsResponse extends AbstractResponse
{
    /*
     * An object which contains title of the chart data, daily values, dates and more.
     * Ready to be rendered in HighCharts.js
     */
    public ?array $chartData = null;

    /*
     * Starting date of the report
     */
    public ?string $fromDate = null;

    /*
     * Ending date of the report
     */
    public ?string $toDate = null;
}

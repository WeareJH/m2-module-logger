<?php

namespace Jh\Logger\Api;

interface ReportManagementInterface
{

    public function sendReport(int $id, string $type);
}

# Logger Module

## Overview

This module was created to extend the core log functionality with database storage.

### Raising an event 
```
    public function addEvent(
        string $type,
        string $message = '',
        string $identifierLabel = '',
        string $identifierValue = '',
        int $severity = 1,
        bool $createIssue = true,
        \Exception $exception = null
    ): bool;
```
which comes from `\Jh\Logger\Api\LoggerManagementInterface`, which can be injected into constructor and used like the following
```
    public function __construct(
        LoggerManagementInterface $loggerManagement,
    ) {
        $this->loggerManagement = $loggerManagement;
    }
``` 
and then can be used `this->loggerManagement->addEvent(...)` with the following arguments above.

### Closing an issue

```
    public function closeIssue(string $type): bool
```
Which comes from `Jh\Logger\Api\LoggerManagementInterface` which can be injected into via constructor method
```
    public function __construct(
        LoggerManagementInterface $loggerManagement,
    ) {
        $this->loggerManagement = $loggerManagement;
    }
```
and then can be used as follows `$this->loggerManagement->closeIssue("API error")` 

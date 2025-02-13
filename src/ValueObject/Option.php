<?php

declare(strict_types=1);

namespace TomasVotruba\PhpFwTrends\ValueObject;

final class Option
{
    /**
     * @var string
     */
    public const PHP_FRAMEWORK_TRENDS = 'php_framework_trends';

    /**
     * @var string
     */
    public const FRAMEWORKS_VENDOR_TO_NAME = 'frameworks_vendor_to_name';

    /**
     * @var string
     */
    public const EXCLUDED_FRAMEWORK_PACKAGES = 'excluded_framework_packages';

    /**
     * @var string
     */
    public const MINIMAL_MONTH_AGE = 'minimal_month_age';

    /**
     * @var string
     */
    public const MIN_DOWNLOADS_LIMIT = 'min_downloads_limit';
}

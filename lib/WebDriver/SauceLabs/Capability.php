<?php
/**
 * Copyright 2012-2020 Anthon Pang. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\SauceLabs;

use WebDriver\Capability as BaseCapability;

/**
 * WebDriver\SauceLabs\Capability class
 *
 * @package WebDriver
 */
class Capability extends BaseCapability
{
    /**
     * Desired capabilities - SauceLabs
     *
     * @see https://wiki.saucelabs.com/display/DOCS/Test+Configuration+Options
     */

    // Selenium specific
    const SELENIUM_VERSION      = 'seleniumVersion';                // Use a specific Selenium version
    const CHROMEDDRIVER_VERSION = 'chromedriverVersion';            // Use a specific Chrome Driver version
    const IEDRIVER_VERSION      = 'iedriverVersion';                // Use a specific Internet Explorer version

    // Alerts
    const AUTO_ACCEPT_ALERTS    = 'autoAcceptAlerts';               // Auto accept alerts (for iOS only)
    // Job Annotation
    const NAME                  = 'name';                           // Name the job
    const BUILD                 = 'build';                          // Record the build number
    const TAGS                  = 'tags';                           // Tag your jobs
    const PASSED                = 'passed';                         // Record pass/fail status
    const CUSTOM_DATA           = 'customData';                     // Record custom data

    // Timeouts
    const MAX_DURATION          = 'maxDuration';                    // Set maximum test duration
    const COMMAND_TIMEOUT       = 'commandTimeout';                 // Set command timeout
    const IDLE_TIMEOUT          = 'idleTimeout';                    // Set idle test timeout

    // Sauce specific
    const VERSION               = 'version';                        // Browser version
    const PRERUN                = 'prerun';                         // Prerun executables
    const TUNNEL_IDENTIFIER     = 'tunnelIdentifier';               // Use identified tunnel
    const PARENT_TUNNEL         = 'parentTunnel';                   // Shared tunnels
    const SCREEN_RESOLUTION     = 'screenResolution';               // Use specific screen resolution
    const TIME_ZONE             = 'timeZone';                       // Time zone
    const AVOID_PROXY           = 'avoidProxy';                     // Avoid proxy
    const DEVICE_ORIENTATION    = 'deviceOrientation';              // Device orientation (portrait or landscape)
    const DEVICE_TYPE           = 'deviceType';                     // Device type (phone or tablet)

    // Job Sharing
    const PUBLIC_RESULTS        = 'public';                         // Make public, private, or share jobs

    // Performance improvements and data collection
    const RECORD_VIDEO          = 'recordVideo';                    // Video recording
    const VIDEO_UPLOAD_ON_PASS  = 'videoUploadOnPass';              // Video upload on pass
    const RECORD_SCREENSHOTS    = 'recordScreenshots';              // Record step-by-step screenshots
    const RECORD_LOGS           = 'recordLogs';                     // Log recording
    const CAPTURE_HTML          = 'captureHtml';                    // HTML source capture
    const PRIORITY              = 'priority';                       // Prioritize jobs
    const QUIET_EXCEPTIONS      = 'webdriverRemoteQuietExceptions'; // Enable Selenium 2's automatic screenshots
}

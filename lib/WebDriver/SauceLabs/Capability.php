<?php

/**
 * @copyright 2012 Anthon Pang
 * @license Apache-2.0
 *
 * @package WebDriver
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */

namespace WebDriver\SauceLabs;

/**
 * WebDriver\SauceLabs\Capability class
 *
 * @package WebDriver
 */
final class Capability
{
    /**
     * Desired capabilities - SauceLabs
     *
     * @see https://docs.saucelabs.com/dev/test-configuration-options/
     */

    // Desktop Browser Capabilities - optional
    const CHROMEDDRIVER_VERSION                    = 'chromedriverVersion';                  // Use a specific Chrome Driver version
    const EDGEDRIVER_VERSION                       = 'edgedriverVersion';                    // Use a specific Edge Driver version
    const IEDRIVER_VERSION                         = 'iedriverVersion';                      // Use a specific Internet Explorer version
    const GECKODRIVER_VERSION                      = 'geckodriverVersion';                   // Use a specific Gecko Driver version
    const SELENIUM_VERSION                         = 'seleniumVersion';                      // Use a specific Selenium version

    const AVOID_PROXY                              = 'avoidProxy';                           // Avoid proxy
    const CAPTURE_PERFORMANCE                      = 'capturePerformance';                   // Capture performance
    const EXTENDED_DEBUGGING                       = 'extendedDebugging';                    // Extended debugging
    const SCREEN_RESOLUTION                        = 'screenResolution';                     // Use specific screen resolution

    // Mobile App Appium Capabilities - required
    const APP                                      = 'app';                                  // Path to app you want to test
    const DEVICE_NAME                              = 'deviceName';                           // Name of simulator, emulator, or real device to use
    const PLATFORM_VERSION                         = 'platformVersion';                      // Mobile OS platform version
    const AUTOMATION_NAME                          = 'automationName';                       // Engine: Appium, UiAutomator2, or Selendroid
    const APP_PACKAGE                              = 'appPackage';                           // Name of Java package to run
    const APP_ACTIVITY                             = 'appActivity';                          // Name of Android activity to launch
    const AUTO_ACCEPT_ALERTS                       = 'autoAcceptAlerts';                     // Auto accept alerts (for iOS only)

    // Mobile App Appium Capabilities - optional
    const APPIUM_VERSION                           = 'appiumVersion';                        // Appium driver version you want to use
    const DEVICE_ORIENTATION                       = 'deviceOrientation';                    // Device orientation (portrait or landscape)
    const ORIENTATION                              = 'orientation';                          // (alias)
    const DEVICE_TYPE                              = 'deviceType';                           // Device type (phone or tablet)
    const OTHER_APPS                               = 'otherApps';                            // Dependent apps
    const TABLET_ONLY                              = 'tabletOnly';                           // Select only tablet devices for testing
    const PHONE_ONLY                               = 'phoneOnly';                            // Select only phone devices
    const PRIVATE_DEVICES_ONLY                     = 'privateDevicesOnly';                   // Request allocation of private devices
    const PUBLIC_DEVICES_ONLY                      = 'publicDevicesOnly';                    // Request allocation of public devices
    const CARRIER_CONNECTIVITY_ONLY                = 'carrierConnectivityOnly';              // Allocate only devices connected to a carrier network
    const CACHE_ID                                 = 'cacheId';                              // Keeps a device allocated to you between test sessions
    const SESSION_CREATION_TIMEOUT                 = 'sessionCreationTimeout';               // Number of times the test should attempt to launch a session
    const NEW_COMMAND_TIMEOUT                      = 'newCommandTimeout';                    // Amount of time (in seconds) that the test should allow to launch a test before failing
    const NO_RESET                                 = 'noReset';                              // Keep a device allocated to you during the device cleaning proces
    const CROSSWALK_APPLICATION                    = 'crosswalkApplication';                 // Patched version of ChromeDriver that will work with Crosswalk
    const AUTO_GRANT_PERMISSIONS                   = 'autoGrantPermissions';                 // To disable auto grant permissions
    const ENABLE_ANIMATIONS                        = 'enableAnimations';                     // Enable animations
    const RESIGNING_ENABLED                        = 'resigningEnabled';                     // To allow testing of apps without resigning
    const SAUCE_LABS_IMAGE_INJECTION_ENABLED       = 'sauceLabsImageInjectionEnabled';       // Enables the camera image injection feature
    const SAUCE_LABS_BYPASS_SCREENSHOT_RESTRICTION = 'sauceLabsBypassScreenshotRestriction'; // Bypasses the restriction on taking screenshots for secure screen
    const ALLOW_TOUCH_ID_ENROLL                    = 'allowTouchIdEnroll';                   // Enables the interception of biometric input
    const GROUP_FOLDER_REDIRECT_ENABLED            = 'groupFolderRedirectEnabled';           // Enables the use of the app's private app container directory
    const SYSTEM_ALERTS_DELAY_ENABLED              = 'systemAlertsDelayEnabled';             // Delays system alerts,

    // Desktop and Mobile Capabilities - optional

    // Job Annotation
    const NAME                                     = 'name';                                 // Name the job
    const BUILD                                    = 'build';                                // Record the build number
    const TAGS                                     = 'tags';                                 // Tag your jobs
    const PASSED                                   = 'passed';                               // Record pass/fail status
    const ACCESS_KEY                               = 'accessKey';                            // Access key

    // Job Sharing
    const PUBLIC_RESULTS                           = 'public';                               // Make public, private, or share jobs

    // Performance improvements and data collection
    const CUSTOM_DATA                              = 'custom-data';                          // Record custom data
    const CAPTURE_HTML                             = 'captureHtml';                          // HTML source capture
    const QUIET_EXCEPTIONS                         = 'webdriverRemoteQuietExceptions';       // Enable Selenium 2's automatic screenshots

    const TUNNEL_IDENTIFIER                        = 'tunnelIdentifier';                     // Use identified tunnel
    const PARENT_TUNNEL                            = 'parentTunnel';                         // Shared tunnels
    const RECORD_LOGS                              = 'recordLogs';                           // Log recording
    const RECORD_SCREENSHOTS                       = 'recordScreenshots';                    // Record step-by-step screenshots
    const RECORD_VIDEO                             = 'recordVideo';                          // Video recording
    const VIDEO_UPLOAD_ON_PASS                     = 'videoUploadOnPass';                    // Video upload on pass

    // Timeouts
    const MAX_DURATION                             = 'maxDuration';                          // Set maximum test duration
    const COMMAND_TIMEOUT                          = 'commandTimeout';                       // Set command timeout
    const IDLE_TIMEOUT                             = 'idleTimeout';                          // Set idle test timeout

    // Virtual Device Capabilities
    const PRIORITY                                 = 'priority';                             // Prioritize jobs
    const TIME_ZONE                                = 'timeZone';                             // Time zone
    const PRERUN                                   = 'prerun';                               // Prerun executables (primary key)
    const EXECUTABLE                               = 'executable';                           // Executable (secondary key)
    const ARGS                                     = 'args';                                 // Args (secondary key)
    const BACKGROUND                               = 'background';                           // Background (secondary key)
    const TIMEOUT                                  = 'timeout';                              // Timeout (secondary key)

    // obsolete
    const VERSION                                  = 'version';                              // Browser version
}

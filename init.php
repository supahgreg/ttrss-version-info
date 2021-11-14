<?php
class Version_Info extends Plugin {
  /** @return array<null|float|string|bool> */
  function about() {
    return [
      0.6, // version
      'Show the tt-rss version using Shift+V.', // description
      'wn', // author
      false, // is system
      'https://github.com/supahgreg/ttrss-version-info', // more info URL
    ];
  }


  /** @return int */
  function api_version() {
    return 2;
  }


  /**
   * @param PluginHost $host
   *
   * @return void
   **/
  function init($host) {
    $host->add_hook($host::HOOK_HOTKEY_MAP, $this);
    $host->add_hook($host::HOOK_HOTKEY_INFO, $this);
  }


  /**
   * @param array<string, string> $hotkeys
   * @return array<string, string>
   */
  function hook_hotkey_map($hotkeys) {
    $hotkeys['V'] = 'show_version';
    return $hotkeys;
  }


  /**
   * @param array<string, array<string, string>> $hotkeys
   * @return array<string, array<string, string>>
   */
  function hook_hotkey_info($hotkeys) {
    $hotkeys[__('Other')]['show_version'] = __('Show tt-rss version info');
    return $hotkeys;
  }


  function show_version(): void {
    $ttrss_version = Config::get_version(false);
    print '<a target="_blank" rel="noreferrer noopener" href="https://git.tt-rss.org/git/tt-rss/commit/' . $ttrss_version['commit'] . '">';
    print $ttrss_version['version'];

    if (is_numeric($ttrss_version['timestamp'])) {
      print ' (' . TimeHelper::make_local_datetime(gmdate("Y-m-d H:i:s", (int) $ttrss_version['timestamp']), true, null, true) . ')';
    }

    print '</a>';
  }


  /** @return string */
  function get_js() {
    return file_get_contents(__DIR__ . '/init.js');
  }
}

<?php
class Version_Info extends Plugin {
  /** @return array<null|float|string|bool> */
  function about() {
    return [
      null, // version
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
    // @phpstan-ignore-next-line '__()' returns strings
    return $hotkeys;
  }


  function show_version(): void {
    /** @var array{'status': int, 'version': string, 'commit'?: string, 'timestamp'?: int|string} */
    $ttrss_version = Config::get_version(false);
    $is_git = array_key_exists('commit', $ttrss_version) && array_key_exists('timestamp', $ttrss_version);

    if (!$is_git) {
      print $ttrss_version['version'];
      return;
    }

    print '<a target="_blank" rel="noreferrer noopener" href="https://dev.tt-rss.org/fox/tt-rss/commit/' . $ttrss_version['commit'] . '">';
    print $ttrss_version['version'];
    print ' (' . TimeHelper::make_local_datetime(gmdate("Y-m-d H:i:s", (int) $ttrss_version['timestamp']), true, null, true) . ')';
    print '</a>';
  }


  /** @return string */
  function get_js() {
    return file_get_contents(__DIR__ . '/init.js') ?: '';
  }
}

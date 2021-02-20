<?php
class Version_Info extends Plugin {

  private $host;


  function about() {
    return [
      0.4, // version
      'Show the tt-rss version using Shift+V.', // description
      'wn', // author
      false, // is system
      'https://github.com/supahgreg/ttrss-version-info', // more info URL
    ];
  }


  function api_version() {
    return 2;
  }


  function init($host) {
    $this->host = $host;
    $host->add_hook($host::HOOK_HOTKEY_MAP, $this);
    $host->add_hook($host::HOOK_HOTKEY_INFO, $this);
  }


  function hook_hotkey_map($hotkeys) {
    $hotkeys['V'] = 'show_version';
    return $hotkeys;
  }


  function hook_hotkey_info($hotkeys) {
    $hotkeys[__('Other')]['show_version'] = __('Show tt-rss version info');
    return $hotkeys;
  }


  function show_version() {
    global $ttrss_version;
    print '<a target="_blank" rel="noreferrer noopener" href="https://git.tt-rss.org/git/tt-rss/commit/' . $ttrss_version['commit'] . '">';
    print get_version();
    print ' (' . TimeHelper::make_local_datetime(gmdate("Y-m-d H:i:s", $ttrss_version['timestamp']), true, false, true) . ')';
    print '</a>';
  }


  function get_js() {
    return file_get_contents(__DIR__ . '/init.js');
  }
}

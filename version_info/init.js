require(['dijit/Dialog', 'dojo/ready'], (Dialog, ready) => {
  ready(() => {
    const version_info_endpoint = 'backend.php?op=pluginhandler&plugin=version_info&method=show_version';
    const dialog = new Dialog({
      id: 'showVersionDlg',
      title: __('Version'),
      href: version_info_endpoint,
    });
    
    App.hotkey_actions['show_version'] = () => {
      dialog.set('href', version_info_endpoint); // force a new request
      dialog.show();
    }
  });
});


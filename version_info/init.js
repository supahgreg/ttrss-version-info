require(['dijit/Dialog', 'dojo/ready'], (Dialog, ready) => {
  ready(() => {
    const version_info_endpoint = 'backend.php?op=pluginhandler&plugin=version_info&method=show_version';
        const dialog = new Dialog({
      id: 'showVersionDlg',
      title: __('Version'),
    });

    dojo.connect(dialog, 'onShow', () => {
      xhrPost('backend.php', {op: 'pluginhandler', plugin: 'version_info', method: 'show_version'}, (transport) => {
        dialog.attr('content', transport.responseText);
          });
        });

    App.hotkey_actions['show_version'] = () => { dialog.show(); }
  });
});

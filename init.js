require(['dijit/Dialog', 'dojo/ready'], (Dialog, ready) => {
  ready(() => {
    const dialog = new Dialog({
      id: 'showVersionDlg',
      title: __('Version'),
    });

    App.hotkey_actions['show_version'] = () => {
      xhr.post('backend.php', {op: 'PluginHandler', plugin: 'version_info', method: 'show_version'}, (reply) => {
        dialog.attr('content', reply);
        dialog.show();
      });
    }
  });
});

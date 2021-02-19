require(['dijit/Dialog', 'dojo/ready'], (Dialog, ready) => {
  ready(() => {
    const dialog = new Dialog({
      id: 'showVersionDlg',
      title: __('Version'),
    });

    dojo.connect(dialog, 'onShow', () => {
      xhr.post('backend.php', {op: 'pluginhandler', plugin: 'version_info', method: 'show_version'}, (reply) => {
        dialog.attr('content', reply);
      });
    });

    App.hotkey_actions['show_version'] = () => { dialog.show(); }
  });
});

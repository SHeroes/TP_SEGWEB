$(function () {

  var App = {

    //TODO: Find a better way to set these from config.php
    baseUrl : '',
    maxCharacters: 320,
    maxPostsPerPage : 5,

    init: function () {
      this.setElements();
      this.bindEvents();
    },

    styles: function () {
      this.navBarStyle();
    },


    // Cache all the jQuery selectors for easy reference.
    setElements: function () {
      this.$messageBox = $('#txtNewMessage');
      this.$numChars = $('#spanNumChars');
      this.$myMessages = $('#tblMyMessages tbody');
      this.$newUserButton = $('#btnCreateUser');
      this.$modUserButton = $('#btnModifyUser');
      this.$modResetPassword = $('#btnResetPassUser');

      this.$delUserButton = $('#btnDeleteUser');

      this.$newSectorButton = $('#btnSubmitSector');
      this.$modSectorButton = $('#btnSubmitModifySector');
      this.$delSectorButton = $('#btnDeleteSector');

      this.$modalWindow = $('#myModal');
    },

    // Bind document events and assign event handlers.
    bindEvents: function () {
      this.$newUserButton.on('click', this.addNewUser);
      this.$modUserButton.on('click', this.modUser);
      this.$modResetPassword.on('click', this.resetPassword);
      this.$delUserButton.on('click', this.delUser);

      this.$newSectorButton.on('click', this.addNewSector);
      this.$modSectorButton.on('click', this.modSector);
      this.$delSectorButton.on('click', this.delSector);

    },

  
    /* *************************************
     *             Event Handlers
     * ************************************* */

    /**
     * Click handler for the Create button in
     * the New User modal window. It grabs data
     * from the form and submits it to the
     * create_new_user function in the Main controller.
     *
     * @param e event
     */
    addNewUser : function (e) {
      var formData = {
        firstName   : $('#new-user #first_name').val(),
        lastName    : $('#new-user #last_name').val(),
        email       : $('#new-user #email').val(),
        perfil_level: $('#new-user #teamId').val(),
        miembro_sector: $('#new-user #miembro_sector').val(),
        password1   : $('#new-user .password').val()
      };
      // TODO: Client-side validation goes here

      var postUrl = App.baseUrl + '/index.php/main_admin/create_new_user';

      $.ajax({
        type: 'POST',
        url: postUrl,
        dataType: 'text',
        data: formData,
        success: App.newUserCreated,
        error: App.alertError
      })

    },

    modUser : function (e) {
      var str = '';
      $("#mod-user .required").each(function (index, elem){
        item = $(elem);
        //console.log(item.attr("placeholder"));
        if (item.val() == ''){ 
          str = str + ' - ' + item.attr("placeholder");
        };
      });
      if (str != ''){
        alert("Campos incompletos: " + str);    
      } else {
        var formData = {
          id: $('#mod-user #id_user').val(),
          firstName   : $('#mod-user #first_name').val(),
          lastName    : $('#mod-user #last_name').val(),
          email       : $('#mod-user #email').val(),
          perfil_level: $('#mod-user #teamId').val(),
          miembro_sector: $('#mod-user #miembro_sector').val(),
          password1   : $('#mod-user .password').val()
        };
        // TODO: Client-side validation goes here

        var postUrl = App.baseUrl + '/index.php/main_admin/update_user';

        $.ajax({
          type: 'POST',
          url: postUrl,
          dataType: 'text',
          data: formData,
          success: App.userModify,
          error: App.userModify
        })
      }
    },

    resetPassword : function (e) {
      var formData = {
        id: $("#id_user_pass_rst").val(),
        password   : 'clave1234'
      };
      // TODO: Client-side validation goes here

      var postUrl = App.baseUrl + '/index.php/main_admin/reset_password';

      $.ajax({
        type: 'POST',
        url: postUrl,
        dataType: 'text',
        data: formData,
        success: App.passReset,
        error: App.alertError
      })

    },

    addNewSector : function (e) {
      var formData = {
        padre   : $('#new-sector #padre').val(),
        denominacion: $('#new-sector #denominacion').val(),
        tipo: $('#new-sector #tipo').val()
      };
      // TODO: Client-side validation goes here
      var postUrl = App.baseUrl + '/index.php/main_admin/create_new_sector';

      $.ajax({
        type: 'POST',
        url: postUrl,
        dataType: 'text',
        data: formData,
        success: App.sectorReload,
        error: App.alertError
      })

    },


    modSector : function (e) {
      var formData = {
        id_sector: $('#mod-sector #id_sector').val(),
        padre   : $('#mod-sector #padre').val(),
        denominacion: $('#mod-sector #denominacion').val(),
        tipo: $('#mod-sector #tipo').val()
      };
      // TODO: Client-side validation goes here
      var postUrl = App.baseUrl + '/index.php/main_admin/update_sector';

      $.ajax({
        type: 'POST',
        url: postUrl,
        dataType: 'text',
        data: formData,
        success: App.sectorReload,
        error: App.alertError
      })

    },

    /**
     * Handler for typing into message textarea.
     * Reduces the characters remaining count by one
     * each time the textarea changes.
     *
     * @param e event
     */
    updateNumChars: function (e) {
      var msgLen = App.$messageBox.val().length;
      var charsLeft = App.maxCharacters - msgLen;

      App.$numChars.text(charsLeft);
    },

    /**
     * Update the user's number of messages label after adding
     * a new message.
     */
    updateMessageCount : function() {
      var tMessages = parseInt( App.$totalMessageCount.text() );
      var messages = parseInt( App.$messageCount.text() );

      App.$totalMessageCount.text( tMessages + 1 );

      // If the messages list has less than 5 messages, update the count label
      if ( messages >= 0 && messages < App.maxPostsPerPage ) {
        App.$messageCount.text( messages + 1 );
      }
    },


    /* *************************************
     *             AJAX Callbacks
     * ************************************* */


     /**
     * Get the newly posted message back from the server
     * and prepend it to the message list.
     *
     * @param result An HTML <tr> string with the new message
     */

     /*
    successfulPost : function( result ) {
      var messageRows = App.$myMessages.children();

      // Reset text box
      App.$messageBox.val('');
      App.$numChars.text(App.maxCharacters);

      // Remove the last posted message from the list
      if ( messageRows.length >= App.maxPostsPerPage ) {
        messageRows.last().remove();
      } else if (messageRows.length <= 1) {
        window.location.reload(true);
      }

      App.updateMessageCount();

      // Put the newly posted message at the top
      App.$myMessages.prepend( result );

      // Send socket.io notification
    },
    */

    /**
     * A new user has been created, and the server has responded (or errored)
     * @param response
     */
    newUserCreated : function(response) {
      if ( response ) {
        App.$modalWindow.modal('hide');
      }
      // TODO: if response not true, show server validation errors
    },

    userModify : function(response) {
      if ( response ) {
        console.log(response);
      }
      // TODO: if response not true, show server validation errors
    },

    passReset :  function(response) {
      if ( response ) {
        console.log(response);
        alert("password reiniciada Correctamente");
      }
      // TODO: if response not true, show server validation errors
    },
        
    sectorReload : function(response) {
      if ( response ) {
        //console.log(response);
        window.location.reload(true);
      }
      // TODO: if response not true, show server validation errors
    },

    /**
     * Util method for blasting an error message on the screen.
     * @param error
     */
    alertError : function( error ) {
       var args = arguments;
       var msg = error.responseText;
    }

  };

  App.init();

  

});

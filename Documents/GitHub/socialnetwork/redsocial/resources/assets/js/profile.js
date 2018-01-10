
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));



const profile = new Vue({
    el: '#profile',
    data: {
    	msg: 'Haz click en el amigo con quien desee hablar:',
    	content: '',
      privateMsgs: [],
      singleMsgs: [],
      msgFrom: '',
      conID: '',
      friend_id: '',
      seen: false,
      newMsgFrom: ''
    },


    ready: function(){
    	this.created();
    },

    created(){
    	axios.get('http://localhost/redsocial/index.php/getMessages')
  			.then(response => {
    			console.log(response.data);		//muestra si sale bien
    			profile.privateMsgs = response.data
  			})
  			.catch(function (error) {
    			console.log(error);			//muestra si sale mal
  			});
    },

    methods:{
    	messages: function(id){
        axios.get('http://localhost/redsocial/index.php/getMessages/' + id)
          .then(response => {
            console.log(response.data);   //muestra si sale bien
            profile.singleMsgs = response.data;
            profile.conID = response.data[0].conversation_id
          })
          .catch(function (error) {
            console.log(error);     //muestra si sale mal
          });
      },

      inputHandler(e){
       if(e.keyCode ===13 && !e.shiftKey){
         e.preventDefault();
         this.sendMsg();
       }
     },

     sendMsg(){
       if(this.msgFrom){
         axios.post('http://localhost/redsocial/index.php/sendMessage', {
          conID: this.conID,
          msg: this.msgFrom
          })
          .then(function (response) {
            console.log(response.data);    //muestra si sale bien

            if(response.status === 200){
              profile.singleMsgs = response.data;
            }
            
          })
          .catch(function (error) {
            console.log(error);     //muestra si sale mal
          });
       }
      },

      sendMsgOnline(id){
       if(this.msgFrom){
         axios.post('http://localhost/redsocial/index.php/sendMessageOnline' +id, {
          conID: this.conID,
          msg: this.msgFrom
          })
          .then(function (response) {
            console.log(response.data);    //muestra si sale bien

            if(response.status === 200){
              profile.singleMsgs = response.data;
            }
            
          })
          .catch(function (error) {
            console.log(error);     //muestra si sale mal
          });
       }
      },

      friendID: function(id){
       profile.friend_id = id;
      },

      sendNewMsg(){
       axios.post('http://localhost/redsocial/index.php/sendNewMessage', {
              friend_id: this.friend_id,
              msg: this.newMsgFrom,
            })
            .then(function (response) {
              console.log(response.data); // show if success
              if(response.status===200){
                window.location.replace('http://localhost/redsocial/index.php/messages');
                profile.msg = 'your message has been sent successfully';
              }

            })
            .catch(function (error) {
              console.log(error); // run if we have error
            });
      }

    }
});
//Vue.config.devtools = true;

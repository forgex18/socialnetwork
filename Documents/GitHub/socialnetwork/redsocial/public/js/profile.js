/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(4);


/***/ }),
/* 4 */
/***/ (function(module, exports) {


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


var profile = new Vue({
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

  ready: function ready() {
    this.created();
  },

  created: function created() {
    axios.get('http://localhost/redsocial/index.php/getMessages').then(function (response) {
      console.log(response.data); //muestra si sale bien
      profile.privateMsgs = response.data;
    }).catch(function (error) {
      console.log(error); //muestra si sale mal
    });
  },


  methods: {
    messages: function messages(id) {
      axios.get('http://localhost/redsocial/index.php/getMessages/' + id).then(function (response) {
        console.log(response.data); //muestra si sale bien
        profile.singleMsgs = response.data;
        profile.conID = response.data[0].conversation_id;
      }).catch(function (error) {
        console.log(error); //muestra si sale mal
      });
    },

    inputHandler: function inputHandler(e) {
      if (e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        this.sendMsg();
      }
    },
    sendMsg: function sendMsg() {
      if (this.msgFrom) {
        axios.post('http://localhost/redsocial/index.php/sendMessage', {
          conID: this.conID,
          msg: this.msgFrom
        }).then(function (response) {
          console.log(response.data); //muestra si sale bien

          if (response.status === 200) {
            profile.singleMsgs = response.data;
          }
        }).catch(function (error) {
          console.log(error); //muestra si sale mal
        });
      }
    },
    sendMsgOnline: function sendMsgOnline(id) {
      if (this.msgFrom) {
        axios.post('http://localhost/redsocial/index.php/sendMessageOnline' + id, {
          conID: this.conID,
          msg: this.msgFrom
        }).then(function (response) {
          console.log(response.data); //muestra si sale bien

          if (response.status === 200) {
            profile.singleMsgs = response.data;
          }
        }).catch(function (error) {
          console.log(error); //muestra si sale mal
        });
      }
    },


    friendID: function friendID(id) {
      profile.friend_id = id;
    },

    sendNewMsg: function sendNewMsg() {
      axios.post('http://localhost/redsocial/index.php/sendNewMessage', {
        friend_id: this.friend_id,
        msg: this.newMsgFrom
      }).then(function (response) {
        console.log(response.data); // show if success
        if (response.status === 200) {
          window.location.replace('http://localhost/redsocial/index.php/messages');
          profile.msg = 'your message has been sent successfully';
        }
      }).catch(function (error) {
        console.log(error); // run if we have error
      });
    }
  }
});
//Vue.config.devtools = true;

/***/ })
/******/ ]);
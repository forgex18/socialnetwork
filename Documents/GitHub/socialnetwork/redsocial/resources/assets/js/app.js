
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




const app = new Vue({
    el: '#app',
    data: {
    	msg: 'Update New Post:',
    	content: '',
    	posts: [],
      likes: [],
    },


    ready: function(){
    	this.created();
    },

    created(){
    	axios.get('http://localhost/redsocial/index.php/postsjson')
  			.then(response => {
    			console.log(response);		//muestra si sale bien
    			this.posts = response.data
          Vue.filter('myOwnTime', function(value){
            return moment(value).locale('es').fromNow();
          });

  			})
  			.catch(function (error) {
    			console.log(error);			//muestra si sale mal
  			});

        //LIKES
        axios.get('http://localhost/redsocial/index.php/likes')
          .then(response => {
            console.log(response);    //muestra si sale bien
            this.likes = response.data;
          })
          .catch(function (error) {
            console.log(error);     //muestra si sale mal
        });
    },

    methods:{
    	addPost(){
    		//alert('test function');

    		axios.post('http://localhost/redsocial/index.php/addPost', {
    			content: this.content
  			})
  			.then(function (response) {
    			console.log("Guardado correctamente");		//muestra si sale bien
    			if(response.status === 200){
    				app.posts = response.data;
    			}
  			})
  			.catch(function (error) {
    			console.log(error);			//muestra si sale mal
  			});
    	},

      deletePost(idpost){
        axios.get('http://localhost/redsocial/index.php/deletePost/' +idpost)
        .then(response => {
          console.log(response);    //muestra si sale bien
          this.posts = response.data
        })
        .catch(function (error) {
          console.log(error);     //muestra si sale mal
        });
      },

      likePost(idpost){
        axios.get('http://localhost/redsocial/index.php/likePost/' +idpost)
        .then(response => {
          console.log(response);    //muestra si sale bien
          this.posts = response.data
          window.location.reload(true);
        })
        .catch(function (error) {
          console.log(error);     //muestra si sale mal
        });
      }

    }
});
//Vue.config.devtools = true;

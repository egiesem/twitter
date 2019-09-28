<template>
 <div class="main-wrapper">
        <div class="header">Twitter Application</div>
        <div class="wrapper-content">
            <div class="wrapper-form">
                <div class="form-login">
                    <label for="login">LOGIN</label>
                    <form  @submit.prevent="submitPost" type="post">
                        <input type="email" v-model="posts.email"  placeholder="Email">
                        <input type="password" v-model="posts.password" placeholder="Password">
                        <button type="submit">Login</button>
                    </form>
                </div>

                <div class="line"></div>

                <div class="form-register">
                    <label for="Register">REGISTER</label>
                    <form @submit.prevent="submitReg" type="post">
                        <input type="email" v-model="posts.emailr" placeholder="Email">
                        <input type="text" v-model="posts.namer" placeholder="Name">
                        <input type="password" v-model="posts.passwordr" placeholder="Password">
                        <button type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  meta: {
      title: 'Twitter Application',
      metaTags: [
          {
              name: 'description',
              content: 'Twitter Application Laravel VueJS'
          },
          {
              property: 'og:description',
              content: 'Twitter Application Laravel VueJS'
          }
      ]
  },
  data() {
    return {
      posts: {
          email:'',
          password:'',

          namer: '',
          emailr:'',
          passwordr:'',
      },
      errors: []
    }
  },

  mounted(){
    console.log('login termount');
  },
  methods:{
    submitPost() {
        this.$Progress.start()
        axios.post('/', this.posts)
        .then(response => {  
            console.log(response);
        //   console.log('berhasil login')
        //   console.log(response.data.error)
          if(response.data.error==false){
            this.$Progress.finish()

            //alert('login berhasil')
            let urlNext= response.data.next
            if(urlNext=='status'){
                urlNext='/status'
            }else{
                urlNext=BaseUrl
            }
            
            setTimeout(function () {
                window.location.href = urlNext
            }, 2000);
            // this.$router.push({path: urlNext})
            Toast.fire({
              type: 'success',
              title: 'Login berhasil, anda akan segera dialihkan...'
            })
              
          }else{
            Toast.fire({
                type: 'error',
                title: 'Username atau password salah!'
            })
          }

        })
        .catch(e => {
          this.$Progress.fail()
            Toast.fire({
                type: 'error',
                title: 'Ups ada yang salah, silahkan coba lagi!'
            })
          if(e.response.status == 422){
          // this.errors = e.response.data.errors
            Toast.fire({
                type: 'error',
                title: 'Isi data terlebih dahulu!'
            })
          }
          
        })
    },


     submitReg() {
        this.$Progress.start()
        axios.post('/reg', this.posts)
        .then(response => {  
            console.log(response);
        // //   console.log('berhasil login')
        // //   console.log(response.data.error)
          if(response.data.error==false){
            this.$Progress.finish()
            // this.$router.push({path: urlNext})
            Toast.fire({
              type: 'success',
              title: 'Pendaftaran berhasil, silahkan login'
            })
              
          }else{
            Toast.fire({
                type: 'error',
                title: 'Pendaftaran gagal!'
            })
          }

        })
        .catch(e => {
          this.$Progress.fail()
            Toast.fire({
                type: 'error',
                title: 'Ups ada yang salah, silahkan coba lagi!'
            })
          if(e.response.status == 422){
          // this.errors = e.response.data.errors
            Toast.fire({
                type: 'error',
                title: 'Isi data terlebih dahulu!'
            })
          }
          
        })
    }


  }



}
</script>
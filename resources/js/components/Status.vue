<template>
    <div class="main-wrapper">
        <div class="header">Twitter Application</div>
        <router-link to="/profile">Profile</router-link>
        <a :href="base_url + '/logout'" >Logout</a>

        <div class="wrapper-content status">
            <div class="wrapper-status">
                <div class="form-status">
                    <form @submit.prevent="submitPost">
                        <textarea name="" id="" cols="20" rows="3" placeholder="Update Status" v-model="posts.status"></textarea>
                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>

            <div class="wrapper-form status-f">
                <div class="list-status">
                    <div v-for="(post) in StatusDatas" :key="post.id" :class=" post.id_user == curentId ? 'right' : 'left' ">
                        <div class="img">
                            <img :src="currentImg && post.id_user == curentId ? currentImg : 'user.png'" alt="">
                        </div>
                        <div class="text">
                            <div class="user">{{post.name}}</div>
                            <div class="status-content">{{post.isi}}</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        


    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
        posts: {
            status:'',
        },
        curentId: '',
        currentImg: null,
        StatusDatas: {},
        errors: [],
        base_url: window.location.origin
    }
  },

  mounted(){
    console.log('login termount');
    this.getCurrentUser()
    this.getDataStatus()
  },
  methods:{
    submitPost() {
        console.log(this.posts)
        this.$Progress.start()
        axios.post('/status', this.posts)
        .then(response => {  
            console.log(response);
          if(response.data.error==false){
            this.$Progress.finish()
            this.getDataStatus()
            
            Toast.fire({
              type: 'success',
              title: 'Update status berhasil..'
            })
              
          }else{
            Toast.fire({
                type: 'error',
                title: 'Update status gagal!'
            })
          }

        })
        .catch(e => {
            console.log(e)
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

    getCurrentUser(){
        axios.get('/get-current-user')
            .then(response => {
                this.curentId = response.data.id
                this.currentImg = response.data.image
                console.log(this.curentId)
                console.log('ini loh', this.currentImg)
            })
    },

    getDataStatus() {
        this.$Progress.start()

        axios.get('/data-status')
            .then(response => {
                this.$Progress.finish()
                this.StatusDatas = response.data;
                console.log(this.StatusDatas)
            });
    },

  }
}
</script>
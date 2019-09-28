<template>
    <div class="main-wrapper">
        <div class="header">Twitter Application</div>

        <div class="wrapper-content profile">
            <div class="wrapper-form profile-f">
                <div class="form-upload profile-u">
                    <img :src="curent.image ? curent.image : 'user.png'" alt="">
                    <input type="file" style="width:150px" id="inputPassword3" ref="fileInput" placeholder="Image" v-on:change="onImageChange">
                    
                </div>

                <div class="form-profile-detail profile-d">
                    <form @submit.prevent="submitPost">
                        <input type="email" v-model="curent.email" placeholder="Email">
                        <input type="text" v-model="curent.name" placeholder="Name">
                        <input type="password" v-model="curent.password" placeholder="Password *optional">
                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
        


    </div>
</template>

<script>
export default {
    data() {
    return {
        posts: {
            status:'',
        },
        curent: {
            name: '',
            email:'',
            password:'',
        },
        image: '',
        errors: [],
        base_url: window.location.origin
    }
  },

  mounted(){
    console.log('login termount');
    this.getCurrentUser()
  },
  methods:{
    submitPost() {
        console.log(this.posts)
        this.$Progress.start()
        axios.post('/update-profile', this.curent)
        .then(response => {  
            console.log(response);
          if(response.data.error==false){
            this.$Progress.finish()
            this.getCurrentUser()
            
            Toast.fire({
              type: 'success',
              title: 'Update profile berhasil..'
            })
              
          }else{
            Toast.fire({
                type: 'error',
                title: 'Update profile gagal!'
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
                this.curent = response.data
                console.log(this.curent)
            })
    },

    onImageChange(e){
        console.log(e.target.files[0]);
        this.image = e.target.files[0];

        //validate size
        if(this.image.size > 2000000){
            alert('image size too large! (max 2 mb)')
            return false
        }

        // debugger
        
        //uploading image
        let self = this
        e.preventDefault();
        let currentObj = this;
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        let formData = new FormData();
        formData.append('image', this.image);
        axios.post('/uploadImage' , formData, config )
        .then(response => {
            if(response.data.error==true){
                Toast.fire({
                    type: 'error',
                    title: 'ups ada yang salah, silahkan coba lagi..'
                })
            }else{
                this.getCurrentUser()
                self.isActive = false
                self.image = self.path + response.data.filename
                self.posts.imagename = response.data.filename
                Toast.fire({
                    type: 'success',
                    title: 'Image Uploaded!'
                })
            }
        })

        .catch(e => {
            this.$Progress.fail()
            console.log('error:',e)
            Toast.fire({
                    type: 'error',
                    title: 'Ups, silahkan coba lagi!'
                })
            if(e.response.status == 422){
                this.errors = e.response.data.errors
            }
        
        })


    },


  }
    
}
</script>
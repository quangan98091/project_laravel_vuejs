<template>
    <div>
        <div class="container d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="container row" v-else>
            <div class="col-md-4 col-sm-6" v-for="(category, index) in categories" :key="index">
                <div class="cards category-item">
                    <router-link :to="{name: 'categoryPost', params: {slug: category.slug}}" class="card-img-tiles">
                        <div class="inner">
                            <div class="main-img">
                                <img :src="'img/category/'+ category.thumbnail" :alt="category.title" class="category-img">
                            </div>
                        </div>
                    </router-link>
                    <div class="card-body text-center">
                        <h4 class="card-title">{{category.title}}</h4>
                        <p class="text-muted">Đăng bởi: {{category.user.name}}</p>
                        <router-link :to="{name: 'categoryPost', params: {slug: category.slug}}" class="btn btn-outline-secondary">
                            Xem chi tiết
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <router-view></router-view>

        <div v-if="error">
            <not-found style="text-align: center;"></not-found>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: false,
                categories: {},
                error: null,
            }
        },
        created () {
            this.loading = true
            axios.get("api/getCategoryAll")
            .then(response => {
                this.categories = response.data;
                this.loading = false;
            })
            .catch(error => {
                console.log(error);
                this.loading = true;
                this.error = true
            })
        },
    }
</script>

<style scoped>
.category-item {
    border: 1px solid #0000005c; 
    box-shadow: 0 0 5px #0000005c;  
    border-radius: 12px;
    margin: 10px 10px;
}
.card-img-tiles {
    display: block;
    border-bottom: 1px solid #e1e7ec
}

.card-img-tiles>.inner {
    display: table;
    width: 100%
}

.card-img-tiles .main-img {
    display: table-cell;
    width: 65%;
    padding: 15px;
    vertical-align: middle
}

.card-img-tiles .main-img>img:last-child {
    margin-bottom: 0
}

.card-img-tiles .main-img>img{
    display: block;
    width: 100%;
    margin-bottom: 6px
}

.category-img {
    width: 100%;
    border-radius: 5px;
    max-height: 200px;
    -o-object-fit: cover;
    object-fit: cover;
}

</style>
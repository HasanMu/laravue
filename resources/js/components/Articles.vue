<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" v-model="article.title" class="form-control" placeholder="title">
            </div>

            <div class="form-group">
                <label for="">Body</label>
                <textarea type="text" name="body" v-model="article.body" class="form-control" placeholder="body"></textarea>
            </div>

            <div class="col-md-3 text-right">
                <button type="submit" name="submit" id="submit" class="btn btn-light btn-block">Buat</button>
            </div>
        </form>
        <hr>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#!"
                    @click="fetchArticles(pagination.prev_page_url)"
                    >Kembali</a></li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#!">
                        Halaman {{ pagination.current_page }} Dari {{ pagination.last_page }}
                    </a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#!"
                    @click="fetchArticles(pagination.next_page_url)"
                    >Lanjut</a></li>
            </ul>
        </nav>
        <div class="card card-body mb-4" v-for="article in articles" v-bind:key="article.id">
            <h4>{{ article.title }}</h4>
            <p>{{ article.body }}</p>
            <hr>

            <div class="col-md-12 text-right">
                <button @click="deleteArticle(article.id)" class="btn btn-danger">Hapus</button>
                <button @click="editArticle(article)" class="btn btn-warning">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            articles: [],
            article: {
                id: '',
                title: '',
                body: ''
            },
            article_id: '',
            pagination: {},
            edit: false
        }
    },

    created() {
        this.fetchArticles();
    },

    methods: {
        fetchArticles(page_url) {
            let vm = this;
            page_url = page_url || '/api/articles';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err))
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };

            this.pagination = pagination;
        },
        deleteArticle(id) {
            if (confirm('Are You Sure?')) {
                fetch(`/api/article/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(res => {
                    alert('Article Removed');
                    this.fetchArticles();
                })
                .catch(err => console.log(`api/article/${id}`));
            }
        },
        addArticle() {
            if(this.edit === false){
                // Add
                fetch(`/api/article`, {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type' : 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('Add success')
                    this.fetchArticles()
                })
                .catch(err => console.log(err));
            } else {
                // Update
                fetch(`/api/article`, {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type' : 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('Update success')
                    this.fetchArticles()
                })
                .catch(err => console.log(err));
            }
        },
        editArticle(article) {
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        }
    },
}
</script>

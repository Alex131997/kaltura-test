<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div>
                    <form @submit="search()" onSubmit="return false;">
                        <div class="form-group">
                            <input class="form-control" minlength="3" maxlength="255" name="search" type="text"
                                   v-model="searchString" placeholder="Search">
                        </div>
                        <div class="form-group">
                            <label for="orderBy">Order by:</label>
                            <select @change="getMediaObjects()" class="form-control" v-model="orderBy" name="orderBy"
                                    id="orderBy">
                                <option value="createdAtUp">Created At (latest to top)</option>
                                <option value="createdAtDown">Created At (latest to down)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th scope="col">Thumbnai</th>
                        <th scope="col">Name</th>
                        <th scope="col">Id</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="mediaObject in mediaObjects">
                        <td data-label="Thumbnai">
                            <a target="_blank" :href="mediaObject.link">
                                <img :src="mediaObject.thumbnai_link" :alt="mediaObject.description">
                            </a>
                        </td>
                        <td data-label="Name">{{mediaObject.name}}</td>
                        <td data-label="Id">{{mediaObject.id}}</td>
                        <td data-label="Created At">{{mediaObject.created_at}}</td>
                        <td data-label="Actions">
                            <img @click="deleteMedia(mediaObject.id)" class="delete-icon" src="/storage/delete.png"
                                 title="Delete media object">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <paginate v-if="pageCount"
                          :page-count="pageCount"
                          :page-range="3"
                          :margin-pages="2"
                          :click-handler="switchPage"
                          :prev-text="'Prev'"
                          :next-text="'Next'"
                          :container-class="'pagination'"
                          :page-class="'page-item'"
                          :page-link-class="'page-link'"
                          :prev-class="'page-item'"
                          :prev-link-class="'page-link'"
                          :next-class="'page-item'"
                          :next-link-class="'page-link'">
                </paginate>
            </div>
        </div>
    </div>
</template>

<script>
    const DEFAULT_PAGE_NUMBER = 1;
    export default {
        data() {
            return {
                pageCount: 0,
                pageNumber: DEFAULT_PAGE_NUMBER,
                countPerPage: 10,
                mediaObjects: {},
                searchString: '',
                orderBy: 'createdAtUp',
            }
        },
        created() {
            this.getMediaObjects();
        },
        methods: {
            getMediaObjects() {
                let loader = this.$loading.show({
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });

                axios.get(`/media/list?orderBy=${this.orderBy}&search=${this.searchString}&page=${this.pageNumber}`)
                    .then((response) => {
                        this.calculateCountPage(response.data.data.totalCount);
                        this.mediaObjects = response.data.data.objects.data;
                        loader.hide();
                    }).catch(() => {
                    loader.hide();
                });
            },
            deleteMedia(id) {
                let loader = this.$loading.show({
                    container: this.fullPage ? null : this.$refs.formContainer,
                    canCancel: true,
                    onCancel: this.onCancel,
                });
                axios.delete(`/media/${id}`)
                    .then((response) => {
                        this.mediaObjects = this.mediaObjects.filter((media) => {
                            return media.id !== id;
                        });
                        loader.hide();
                    }).catch(() => {
                    loader.hide();
                });
            },
            getCount() {
                axios.get(`/media/count`)
                    .then((response) => {
                        this.pageCount = Math.ceil(response.data.data.count / this.countPerPage);
                    });
            },
            calculateCountPage(countObjects) {
                this.pageCount = Math.ceil(countObjects / this.countPerPage);
            },
            switchPage(pageNum) {
                this.pageNumber = pageNum;
                this.getMediaObjects();
            },
            search() {
                this.pageNumber = DEFAULT_PAGE_NUMBER;
                this.getMediaObjects();
            },
        }
    }
</script>

<style>
    .delete-icon {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        cursor: pointer;
    }

    .pagination {
        margin-top: 10px;
    }

    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: 1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }
    }
</style>

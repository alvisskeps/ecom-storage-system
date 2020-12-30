<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <button class="btn btn-success mx-2" @click="triggerModal(false)">Add new product</button>
            </div>
        </div>
        <div class="row no-gutters my-5">
            <div v-for="(product, index) in products" :key="index" class="col-lg-3 col-md-4 col-sm-6">
                <div class="card mx-2 my-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="card-text">{{ product.description }}</p>
                        <p><b>Price: </b>{{ product.price }}</p>
                        <p><b>Amount: </b>{{ product.amount }}</p>
                        <button class="btn btn-primary" @click="triggerModal(true, product)">Edit</button>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <b-modal
            v-model="showModal"
            id="modal-prevent-closing"
            ref="modal"
            size="lg"
            @hide="resetData"
        >
            <div slot="modal-header">
                <h5 class="modal-title">{{ shouldEdit ? 'Edit' : 'Add new' }} product</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Product name</label>
                        <input v-model="productData.name" type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Product description</label>
                        <textarea v-model="productData.description" type="text" class="form-control" placeholder="Description" rows="3"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Price EUR</label>
                        <input v-model="productData.price" type="text" class="form-control" placeholder="Price">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Amount</label>
                        <input v-model="productData.amount" type="number" class="form-control" placeholder="Amount">
                    </div>
                </div>
                <div v-if="errors.length" class="row">
                    <ul>
                        <li v-for="(error, index) in errors" :key="index" style="color: red;">
                            {{ error }}
                        </li>
                    </ul>
                </div>
            </div>
            <div slot="modal-footer">
                <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                <button type="button" class="btn btn-primary" @click="onSaveClicked">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ProductList",
    data: () => ({
        products: [],
        showModal: false,
        shouldEdit: false,
        selectedProductId: null,
        errors: [],
        productData: {
            name: '',
            description: '',
            price: null,
            amount: null,
        }
    }),
    created() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios
                .get('api/products')
                .then(response => {
                    this.products = response.data;
                });
        },
        deleteProduct(productId) {
            axios
                .delete(`/api/products/${productId}`)
                .then(response => {
                    this.getProducts();
                    alert(response.data.message);
                });
        },
        triggerModal(shouldEdit, selectedProduct = null) {
            this.shouldEdit = shouldEdit;
            this.selectedProductId = selectedProduct ? selectedProduct.id : null;
            this.productData = {...this.productData, ...selectedProduct}
            this.showModal = true;
        },
        onSaveClicked() {
            if (!this.validateInput()) {
                this.shouldEdit ? this.editProduct() : this.createProduct();
            }
        },
        editProduct() {
            axios
                .put(`/api/products/${this.selectedProductId}`, this.productData)
                .then(response => {
                    this.getProducts();
                    this.showModal = false;
                    alert(response.data.message);
                });
        },
        createProduct() {
            axios
                .post(`/api/products`, this.productData)
                .then(response => {
                    this.getProducts();
                    this.showModal = false;
                    alert(response.data.message);
                });
        },
        resetData() {
            this.showModal = false;
            this.shouldEdit = false;
            this.selectedProductId = null;
            this.errors = [];
            this.productData = {
                name: '',
                description: '',
                price: null,
                amount: null,
            };
        },
        validateInput() {
            this.errors = [];

            if (!this.productData.name) {
                this.errors.push("Please enter product name");
            }

            if (!this.productData.description) {
                this.errors.push("Please enter product description");
            }

            if (!this.productData.price) {
                this.errors.push("Please enter product price");
            }

            if (!this.productData.amount) {
                this.errors.push("Please enter product amount");
            }

            return this.errors.length;
        },
    }
}
</script>

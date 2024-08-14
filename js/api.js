// api.js
let BASE_URL = '../back-end/index.php';
 BASE_URL = 'https://shop.test/back-end/index.php';
// Fonction générique pour les appels API
const fetchData = async (endpoint, options = {}) => {
    try {
        const response = await fetch(`${BASE_URL}${endpoint}`, options);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
};

// Produits
export const getProducts = () => fetchData('/products');
export const getProductById = (id) => fetchData(`/products/${id}`);
export const createProduct = (data) => fetchData('/products', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateProduct = (id, data) => fetchData(`/products/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteProduct = (id) => fetchData(`/products/${id}`, { method: 'DELETE' });

// Catégories
export const getCategories = () => fetchData('/categories');
export const getCategoryById = (id) => fetchData(`/categories/${id}`);
export const createCategory = (data) => fetchData('/categories', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCategory = (id, data) => fetchData(`/categories/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCategory = (id) => fetchData(`/categories/${id}`, { method: 'DELETE' });

// Images de Produits
export const getProductImages = () => fetchData('/product_images');
export const getProductImageById = (id) => fetchData(`/product_images/${id}`);
export const createProductImage = (data) => fetchData('/product_images', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateProductImage = (id, data) => fetchData(`/product_images/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteProductImage = (id) => fetchData(`/product_images/${id}`, { method: 'DELETE' });

// Tailles
export const getSizes = () => fetchData('/sizes');
export const getSizeById = (id) => fetchData(`/sizes/${id}`);
export const createSize = (data) => fetchData('/sizes', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateSize = (id, data) => fetchData(`/sizes/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteSize = (id) => fetchData(`/sizes/${id}`, { method: 'DELETE' });

// Couleurs
export const getColors = () => fetchData('/colors');
export const getColorById = (id) => fetchData(`/colors/${id}`);
export const createColor = (data) => fetchData('/colors', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateColor = (id, data) => fetchData(`/colors/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteColor = (id) => fetchData(`/colors/${id}`, { method: 'DELETE' });

// Avis
export const getReviews = () => fetchData('/reviews');
export const getReviewById = (id) => fetchData(`/reviews/${id}`);
export const createReview = (data) => fetchData('/reviews', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateReview = (id, data) => fetchData(`/reviews/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteReview = (id) => fetchData(`/reviews/${id}`, { method: 'DELETE' });

// Informations Supplémentaires
export const getAdditionalInformation = () => fetchData('/additional_information');
export const getAdditionalInformationById = (id) => fetchData(`/additional_information/${id}`);
export const createAdditionalInformation = (data) => fetchData('/additional_information', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateAdditionalInformation = (id, data) => fetchData(`/additional_information/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteAdditionalInformation = (id) => fetchData(`/additional_information/${id}`, { method: 'DELETE' });

// Utilisateurs
export const getUsers = () => fetchData('/users');
export const getUserById = (id) => fetchData(`/users/${id}`);
export const createUser = (data) => fetchData('/users', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateUser = (id, data) => fetchData(`/users/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteUser = (id) => fetchData(`/users/${id}`, { method: 'DELETE' });

// Produits Associés
export const getRelatedProducts = () => fetchData('/related_products');
export const getRelatedProductById = (id) => fetchData(`/related_products/${id}`);
export const createRelatedProduct = (data) => fetchData('/related_products', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateRelatedProduct = (id, data) => fetchData(`/related_products/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteRelatedProduct = (id) => fetchData(`/related_products/${id}`, { method: 'DELETE' });

// Panier
export const getCarts = () => fetchData('/carts');
export const getCartById = (id) => fetchData(`/carts/${id}`);
export const createCart = (data) => fetchData('/carts', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCart = (id, data) => fetchData(`/carts/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCart = (id) => fetchData(`/carts/${id}`, { method: 'DELETE' });

// Éléments du Panier
export const getCartItems = () => fetchData('/cart_items');
export const getCartItemById = (id) => fetchData(`/cart_items/${id}`);
export const createCartItem = (data) => fetchData('/cart_items', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCartItem = (id, data) => fetchData(`/cart_items/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCartItem = (id) => fetchData(`/cart_items/${id}`, { method: 'DELETE' });

// Commandes
export const getOrders = () => fetchData('/orders');
export const getOrderById = (id) => fetchData(`/orders/${id}`);
export const createOrder = (data) => fetchData('/orders', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateOrder = (id, data) => fetchData(`/orders/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteOrder = (id) => fetchData(`/orders/${id}`, { method: 'DELETE' });

// Détails des Commandes
export const getOrderDetails = () => fetchData('/order_details');
export const getOrderDetailById = (id) => fetchData(`/order_details/${id}`);
export const createOrderDetail = (data) => fetchData('/order_details', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateOrderDetail = (id, data) => fetchData(`/order_details/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteOrderDetail = (id) => fetchData(`/order_details/${id}`, { method: 'DELETE' });

// Favoris
export const getFavorites = () => fetchData('/favorites');
export const getFavoriteById = (id) => fetchData(`/favorites/${id}`);
export const createFavorite = (data) => fetchData('/favorites', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateFavorite = (id, data) => fetchData(`/favorites/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteFavorite = (id) => fetchData(`/favorites/${id}`, { method: 'DELETE' });

// API pour les Bannières
export const getBanners = () => fetchData('/banners');

export const getBannerById = (id) => fetchData(`/banners/${id}`);

export const createBanner = (data) => fetchData('/banners', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});

export const updateBanner = (id, data) => fetchData(`/banners/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});

export const deleteBanner = (id) => fetchData(`/banners/${id}`, { method: 'DELETE' });

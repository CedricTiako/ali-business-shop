import * as api from './api.js';
 // Ensure you have jQuery if using it for Slick slider

// Fonction pour afficher les produits dans le carousel
const displayProductsCarousel = async () => {
    try {
        const products = await api.getProducts();
        const container = document.getElementById('product-carousel');
        const fragment = document.createDocumentFragment(); // Utilisation de DocumentFragment pour améliorer la performance

        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'item-slick2 p-l-15 p-r-15';

            productDiv.innerHTML = `
                <div class="block2">
                    <div class="block2-img wrap-pic-w of-hidden pos-relative ${product.is_new ? 'block2-labelnew' : ''} ${product.is_sale ? 'block2-labelsale' : ''}">
                        <img src="${product.image_url}" alt="${product.name}">
                        <div class="block2-overlay trans-0-4">
                            <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4" data-product-id="${product.id}">
                                <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                            </a>
                            <div class="block2-btn-addcart w-size1 trans-0-4">
                                <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4" data-product-id="${product.id}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="block2-txt p-t-20">
                        <a href="product-detail.html?id=${product.id}" class="block2-name dis-block s-text3 p-b-5">
                            ${product.name}
                        </a>
                        <span class="block2-price m-text6 p-r-5">
                            $${product.price}
                        </span>
                        ${product.is_sale ? `
                        <span class="block2-oldprice m-text7 p-r-5">
                            $${product.old_price}
                        </span>
                        <span class="block2-newprice m-text8 p-r-5">
                            $${product.new_price}
                        </span>` : ''}
                    </div>
                </div>
            `;
            fragment.appendChild(productDiv);
        });

        container.innerHTML = ''; // Vider le conteneur avant d'ajouter les nouveaux produits
        container.appendChild(fragment);

        // Initialiser Slick slider après avoir ajouté les produits
        $('.slick2').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: true,
            arrows: true
        });

        // Ajouter les gestionnaires d'événements
        container.addEventListener('click', handleProductClick);

    } catch (error) {
        console.error('Error displaying products:', error);
    }
};

// Gestionnaire d'événements pour les produits
const handleProductClick = async (event) => {
    const target = event.target;

    if (target.closest('button')) {
        const productId = target.closest('button').getAttribute('data-product-id');
        await addToCart(productId);
    }

    if (target.closest('a[data-product-id]')) {
        const productId = target.closest('a').getAttribute('data-product-id');
        await toggleWishlist(productId);
    }
};

// // Fonction pour ajouter un produit au panier
// const addToCart = async (productId) => {
//     try {
//         const cartId = 1; // Supposons que vous ayez un identifiant de panier
//         const cartItem = { cart_id: cartId, product_id: productId, quantity: 1 };
//         await api.createCartItem(cartItem);
//         showNotification('Product added to cart!');
//     } catch (error) {
//         console.error('Error adding product to cart:', error);
//         showNotification('Failed to add product to cart');
//     }
// };

// // Fonction pour basculer un produit dans les favoris
// const toggleWishlist = async (productId) => {
//     try {
//         const favorites = await api.getFavorites();
//         const isFavorite = favorites.some(fav => fav.product_id === productId);

//         if (isFavorite) {
//             const favorite = favorites.find(fav => fav.product_id === productId);
//             await api.deleteFavorite(favorite.id);
//             showNotification('Removed from favorites');
//         } else {
//             const favorite = { product_id: productId };
//             await api.createFavorite(favorite);
//             showNotification('Added to favorites');
//         }
//     } catch (error) {
//         console.error('Error toggling wishlist:', error);
//         showNotification('Failed to update favorites');
//     }
// };

// Fonction pour afficher les notifications
const showNotification = (message) => {
    // Implémentez votre logique de notification ici
    alert(message); // Exemple simple
};


// Fonction pour afficher les produits
const displayProducts = async () => {
    try {
        const products = await api.getProducts();
        const container = document.getElementById('product-container');
        container.innerHTML = ''; // Vider le conteneur avant d'ajouter les nouveaux produits

        products.forEach(product => {
            const productHTML = `
                <div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
                    <div class="block2">
                        <div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
                            <img src="${product.image_url}" alt="${product.name}">
                            <div class="block2-overlay trans-0-4">
                                <a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4" onclick="toggleWishlist(${product.id})">
                                    <i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
                                    <i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
                                </a>
                                <div class="block2-btn-addcart w-size1 trans-0-4">
                                    <button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4" onclick="addToCart(${product.id})">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="block2-txt p-t-20">
                            <a href="product-detail.html?id=${product.id}" class="block2-name dis-block s-text3 p-b-5">
                                ${product.name}
                            </a>
                            <span class="block2-price m-text6 p-r-5">
                                $${product.price}
                            </span>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += productHTML;
        });
    } catch (error) {
        console.error('Error displaying products:', error);
    }
};

// Fonction pour ajouter un produit au panier
const addToCart = async (productId) => {
    try {
        const cartId = 1; // Supposons que vous ayez un identifiant de panier, généralement stocké dans l'état de l'application ou le sessionStorage
        const cartItem = {
            cart_id: cartId,
            product_id: productId,
            quantity: 1 // Quantité par défaut
        };
        await api.createCartItem(cartItem);
        alert('Product added to cart!');
    } catch (error) {
        console.error('Error adding product to cart:', error);
    }
};

// Fonction pour basculer un produit dans les favoris
const toggleWishlist = async (productId) => {
    try {
        // Vérifier si le produit est déjà dans les favoris
        const favorites = await api.getFavorites();
        const isFavorite = favorites.some(fav => fav.product_id === productId);

        if (isFavorite) {
            // Retirer du panier
            const favorite = favorites.find(fav => fav.product_id === productId);
            await api.deleteFavorite(favorite.id);
            alert('Removed from favorites');
        } else {
            // Ajouter aux favoris
            const favorite = { product_id: productId };
            await api.createFavorite(favorite);
            alert('Added to favorites');
        }
    } catch (error) {
        console.error('Error toggling wishlist:', error);
    }
};

// Fonction pour afficher les bannières
const displayBanners = async () => {
    try {
        // Récupérer les bannières depuis l'API
        const banners = await api.getBanners();
        const container = document.getElementById('banner-container');
        container.innerHTML = ''; // Vider le conteneur avant d'ajouter les nouvelles bannières

        banners.forEach(banner => {
            const bannerHTML = `
                <div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
                    <!-- block1 -->
                    <div class="block1 hov-img-zoom pos-relative m-b-30">
                        <img src="${banner.image_url}" alt="${banner.alt_text}">

                        <div class="block1-wrapbtn w-size2">
                            <!-- Button -->
                            <a href="${banner.link}" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
                                ${banner.title}
                            </a>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += bannerHTML;
        });

        // Ajouter la section promotionnelle finale
        const promoHTML = `
            <div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
                <div class="block2 wrap-pic-w pos-relative m-b-30">
                    <img src="images/icons/bg-01.jpg" alt="IMG">

                    <div class="block2-content sizefull ab-t-l flex-col-c-m">
                        <h4 class="m-text4 t-center w-size3 p-b-8">
                            Sign up & get 20% off
                        </h4>

                        <p class="t-center w-size4">
                            Be the first to know about the latest fashion news and get exclusive offers
                        </p>

                        <div class="w-size2 p-t-25">
                            <!-- Button -->
                            <a href="#" class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += promoHTML;

    } catch (error) {
        console.error('Error displaying banners:', error);
    }
};


const displayCategories = async () => {
    try {
        // Récupérer les catégories depuis l'API
        const categories = await api.getCategories(); // Récupère toutes les catégories
        const container = document.getElementById('categories-list');
        const fragment = document.createDocumentFragment(); // Utilisation de DocumentFragment pour améliorer la performance

        // Ajouter une catégorie "All"
        const allCategoryItem = document.createElement('li');
        allCategoryItem.className = 'p-t-4';
        allCategoryItem.innerHTML = '<a href="#" class="s-text13 active1">All</a>';
        fragment.appendChild(allCategoryItem);

        // Ajouter les autres catégories
        categories.forEach(category => {
            const categoryItem = document.createElement('li');
            categoryItem.className = 'p-t-4';
            categoryItem.innerHTML = `<a href="#" class="s-text13">${category.name}</a>`;
            fragment.appendChild(categoryItem);
        });

        // Mettre à jour le conteneur des catégories
        container.innerHTML = ''; // Vider le conteneur avant d'ajouter les nouvelles catégories
        container.appendChild(fragment);

    } catch (error) {
        console.error('Error displaying categories:', error);
    }
};


// Appel de la fonction pour afficher les bannières lorsque la page se charge
window.onload = () => {
    displayBanners();
    displayProducts();
    displayCategories();
    displayProductsCarousel();
};

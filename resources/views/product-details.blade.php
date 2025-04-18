@extends('layout.app')
@section('content')
    <div class="container">
        <div class="product-container">
            <div class="row">
                <!-- Product Images Column -->
                <div class="col-lg-6 p-4">
                    <div class="login-section d-flex justify-content-between align-items-center">
                        <span id="loginStatus" class="ms-2">
                            {{ Auth::check() ? 'Welcome, '.Auth::user()->name : 'Guest User' }}
                        </span>
                        
                        <button class="login-toggle" onclick="toggleLogin()">
                            <span id="loginButtonText">{{ Auth::check() ? 'Logout' : 'Login' }}</span>
                        </button>

                    </div>
                    
                   <!-- Main Product Image -->
                    <div class="product-image-container mb-4">
                        <img src="{{ asset('product-images/watch-silver.jpg') }}" 
                            class="main-image img-fluid w-100 image-zoom" 
                            id="mainImage" 
                            alt="Luxury Chronograph Watch"
                            onclick="zoomImage(this)">
                    </div>

                    <div class="thumbnail-container d-flex gap-3 mt-3">
                        <img src="{{ asset('product-images/watch-silver.jpg') }}" 
                            class="thumbnail active" 
                            onclick="changeImage(this, '{{ asset('product-images/watch-silver.jpg') }}')"
                            alt="Silver Watch">
                        
                        <img src="{{ asset('product-images/watch-brown.jpg') }}" 
                            class="thumbnail" 
                            onclick="changeImage(this, '{{ asset('product-images/watch-brown.jpg') }}')"
                            alt="Brown Watch">
                        
                        <img src="{{ asset('product-images/watch-brown2.jpg') }}" 
                            class="thumbnail" 
                            onclick="changeImage(this, '{{ asset('product-images/watch-brown2.jpg') }}')"
                            alt="Brown Leather Watch">
                        
                        <img src="{{ asset('product-images/watch-red.jpg') }}" 
                            class="thumbnail" 
                            onclick="changeImage(this, '{{ asset('product-images/watch-red.jpg') }}')"
                            alt="Red Strap Watch">
                    </div>
                </div>
                
                <!-- Product Details Column -->
                <div class="col-lg-6 p-4">
                    <div class="product-brand">Chronograph Series</div>
                    <h1 class="product-title">Luxury Automatic Watch</h1>
                    
                    <!-- Rating -->
                    <div class="mb-3">
                        <span class="text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span class="ms-2">(42 reviews)</span>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="price-section" id="priceContainer">
                        <span class="current-price">Rs. 999.00</span>
                    </div>
                    
                    <!-- Color Options -->
                    <div class="mb-4">
                        <div class="option-title">Color</div>
                        <div>
                            <span class="color-option selected" style="background-color: #2a2a2a;" onclick="selectColor(this, '#2a2a2a', 'Black')"></span>
                            <span class="color-option" style="background-color: #d4af37;" onclick="selectColor(this, '#d4af37', 'Gold')"></span>
                            <span class="color-option" style="background-color: #a8a8a8;" onclick="selectColor(this, '#a8a8a8', 'Silver')"></span>
                            <span class="color-option" style="background-color: #e83e8c;" onclick="selectColor(this, '#e83e8c', 'Rose Gold')"></span>
                        </div>
                        <div class="mt-2" id="selectedColorText">Color: Black</div>
                    </div>
                    
                    <!-- Size Options -->
                    <div class="mb-4">
                        <div class="option-title">Size</div>
                        <div>
                            <span class="size-option selected" onclick="selectSize(this, '38')">38</span>
                            <span class="size-option" onclick="selectSize(this, '40')">40</span>
                            <span class="size-option" onclick="selectSize(this, '42')">42</span>
                            <span class="size-option" onclick="selectSize(this, '44')">44</span>
                        </div>
                        <div class="mt-2" id="selectedSizeText">Size: 38</div>
                    </div>
                    
                    <!-- Quantity Selector -->
                    <div class="mb-4">
                        <div class="option-title">Quantity</div>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="updateQuantity(-1)">-</button>
                            <input type="text" class="quantity-input" id="quantity" value="1" readonly>
                            <button class="quantity-btn" onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>
                    
                    <!-- Total Price -->
                    <div class="total-price">
                        Total: <span id="totalPrice">Rs. 999.00</span>
                    </div>
                    
                    <!-- Action Buttons -->
                    <button class="btn-add-to-cart" onclick="addToCart()">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                    
                    <button class="btn-wishlist" onclick="addToWishlist()">
                        <i class="far fa-heart me-2"></i> Add to Wishlist
                    </button>
                    
                    <!-- Product Description -->
                    <div class="product-description mt-4">
                        <h5 class="option-title">Description</h5>
                        <p>Crafted with precision and elegance, our Luxury Automatic Watch combines Swiss engineering with Italian design. The stainless steel case houses a self-winding mechanical movement visible through the exhibition case back.</p>
                        
                        <ul class="mt-3">
                            <li><i class="fas fa-check-circle text-secondary me-2"></i> Automatic self-winding movement</li>
                            <li><i class="fas fa-check-circle text-secondary me-2"></i> 42-hour power reserve</li>
                            <li><i class="fas fa-check-circle text-secondary me-2"></i> Sapphire crystal glass</li>
                            <li><i class="fas fa-check-circle text-secondary me-2"></i> 50m water resistance</li>
                            <li><i class="fas fa-check-circle text-secondary me-2"></i> Genuine leather strap</li>
                        </ul>
                    </div>
                    
                    <!-- Product Meta -->
                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-title">SKU:</span> CHRONO-2023-BLK
                        </div>
                        <div class="meta-item">
                            <span class="meta-title">Category:</span> Watches
                        </div>
                        <div class="meta-item">
                            <span class="meta-title">Tags:</span> Luxury, Automatic, Chronograph
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
   
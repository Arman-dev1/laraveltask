<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Product Detail')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')
</head>

<body>
    @yield('content')

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="login-toggle w-100">Login</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        let selectedColor = "Black";
        let selectedSize = "38";

        function changeImage(element, newSrc) {
            $('#mainImage').attr('src', newSrc);
            $('.thumbnail').removeClass('active');
            $(element).addClass('active');
        }

        // Zoom image on click
        function zoomImage(element) {
            const $element = $(element);
            if ($element.css('transform') === 'matrix(1.5, 0, 0, 1.5, 0, 0)') {
                $element.css({
                    'transform': 'scale(1)',
                    'cursor': 'zoom-in'
                });
            } else {
                $element.css({
                    'transform': 'scale(1.5)',
                    'cursor': 'zoom-out'
                });
            }
        }

        // Select color option
        function selectColor(element, colorCode, colorName) {
            selectedColor = colorName;
            $('.color-option').removeClass('selected');
            $(element).addClass('selected');
            $('#selectedColorText').text(`Color: ${colorName}`);
        }

        // Select size option
        function selectSize(element, size) {
            selectedSize = size;
            $('.size-option').removeClass('selected');
            $(element).addClass('selected');
            $('#selectedSizeText').text(`Size: ${size}`);
        }

        // Update quantity
        function updateQuantity(change) {
            const $quantityInput = $('#quantity');
            let quantity = parseInt($quantityInput.val()) + change;
            quantity = Math.max(1, Math.min(10, quantity));
            $quantityInput.val(quantity);
            updateTotalPrice();
        }

        // Update total price based on quantity and login status
        function updateTotalPrice() {
            const quantity = parseInt($('#quantity').val());
            const basePrice = isLoggedIn ? 649 : 999;
            const total = (basePrice * quantity).toFixed(2);
            $('#totalPrice').text(`Rs. ${total}`);
        }

        // Add to cart function
        function addToCart() {
            const product = {
                name: "Luxury Automatic Watch",
                color: selectedColor,
                size: selectedSize,
                quantity: $('#quantity').val(),
                price: isLoggedIn ? 649 : 999,
                total: parseFloat($('#totalPrice').text().replace('Rs. ', ''))
            };

            console.log('Product added to cart:', product);
            showNotification('Product added to cart');
        }

        // Add to wishlist function
        function addToWishlist() {
            showNotification('Added to wishlist');
        }

        // Show notification
        function showNotification(message) {
            const toastHtml = `
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-primary text-white">
                            <strong class="me-auto">Notification</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                </div>
            `;

            $(toastHtml).appendTo('body');

            setTimeout(() => {
                $('.position-fixed.top-0.end-0').remove();
            }, 3000);
        }

        function toggleLogin() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (isLoggedIn) {
                logout();
            } else {
                $('#loginModal').modal('show');
            }
        }


        function updateAuthUI() {
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            const quantity = parseInt($('#quantity').val()) || 1;
            
            if (isLoggedIn) {
                $('#priceContainer').html(`
                    <span class="current-price">Rs. 649.00</span>
                    <span class="original-price">Rs. 999.00</span>
                    <span class="discount-badge">35% OFF</span>
                `);
                const total = (649 * quantity).toFixed(2);
                $('.total-price #totalPrice').text(`Rs. ${total}`);
            } else {
                $('#priceContainer').html(`
                    <span class="current-price">Rs. 999.00</span>
                `);
                const total = (999 * quantity).toFixed(2);
                $('.total-price #totalPrice').text(`Rs. ${total}`);
            }
        }

        // Initialize on page load
        $(document).ready(function() {
            updateAuthUI();
            
            // Update when quantity changes
            $('#quantity').on('change', function() {
                updateAuthUI();
            });
        });

        // Call this after successful login/logout
        function handleAuthChange() {
            updateAuthUI();
        }

        // Login
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitButton = form.find('.login-toggle');
                submitButton.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...'
                    );
                submitButton.prop('disabled', true);

                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after(
                                    '<span class="invalid-feedback" role="alert"><strong>' +
                                    value[0] + '</strong></span>');
                            });
                        }
                        showNotification(xhr.responseJSON.message || 'Login failed', 'danger');
                    },
                    complete: function() {
                        submitButton.html('Login');
                        submitButton.prop('disabled', false);
                    }
                });
            });
        });

        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You'll need to login again to access premium features",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("logout") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            Swal.showLoading();
                        },
                        success: function() {
                            Swal.fire(
                                'Logged out!',
                                'You have been successfully logged out.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Logout failed. Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
    @stack('scripts')
</body>

</html>

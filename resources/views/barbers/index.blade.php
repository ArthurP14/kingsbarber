```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    @include('barbers.partials.styles')
</head>

<body>

    @include('barbers.partials.header')

    <div class="hero">

        <div class="fade" aria-hidden="true">
            <i></i>
            <i></i>
            <i></i>
        </div>

        <div class="wrap main">

            <h1 class="display">
                <span>Walk in as yourself.</span>
                <span>Leave Confident.</span>
            </h1>

            <p class="lede">
                More than a haircut. Three chairs, real craft and a hot towel every time.
                Book ahead or walk in.
            </p>

            <div class="cta-row">
                <a class="btn" href="#book">Book now</a>
                <a class="btn ghost" href="#services">See services</a>
            </div>

        </div>

        <div class="strip">
            <div class="wrap">

                <div class="status">
                    <span class="dot" id="dot"></span>
                    <span id="statusText">Checking hours</span>
                </div>

                <button
                    class="next"
                    id="nextBtn"
                    hidden
                    type="button"
                ></button>

                <a
                    class="phone"
                    href="tel:263783885678"
                >
                    Call 263 783 885 678
                </a>

            </div>
        </div>

    </div>

    <div class="marquee" aria-hidden="true">
        <div class="track" id="marquee"></div>
    </div>

    <main id="top">

        @include('barbers.partials.story')

        @include('barbers.partials.services')

        @include('barbers.partials.book')

        @include('barbers.partials.barbers')

        @include('barbers.partials.reviews')

        @include('barbers.partials.faq')

        @include('barbers.partials.visit')

    </main>

    @include('barbers.partials.footer')


    {{-- =========================================================
         JAVASCRIPT BOOT CONFIGURATION
         ========================================================= --}}

    <script>
        window.__BOOT__ = {
            services: @json($services),

            barbers: @json($barbers),

            hours: @json($hours),

            dayNames: @json($dayNames),

            csrf: @json(csrf_token()),

            assetBase: @json(asset('')),

            api: {
                availability: @json(route('api.availability')),
                bookings: @json(route('api.bookings')),
                status: @json(route('api.status'))
            }
        };
    </script>


    {{-- =========================================================
         IRONLINE JAVASCRIPT
         ========================================================= --}}

    <script
        src="{{ asset('js/ironline.js') }}?v={{ time() }}"
        defer
    ></script>

</body>
</html>
```

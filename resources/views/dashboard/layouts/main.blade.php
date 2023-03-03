<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }} | {{ $title }}</title>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-navbar navbar-fixed">
            <header class="mb-3">
                {{-- Navbar --}}
                @include('dashboard.layouts.navbar')
            </header>

            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Welcome back, {{ auth()->user()->name }}!</h3>
                                <p class="text-subtitle text-muted">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, quod in iste
                                    repudiandae doloribus cumque?
                                </p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Dashboard
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">About Vertical Navbar</h4>
                            </div>
                            <div class="card-body">
                                <p>
                                    Vertical Navbar is a layout option that you can use with
                                    Mazer.
                                </p>

                                <p>
                                    In case you want the navbar to be sticky on top while
                                    scrolling, add <code>.navbar-fixed</code> class alongside
                                    with <code>.layout-navbar</code> class.
                                </p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Dummy Text</h4>
                            </div>
                            <div class="card-body">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In
                                    mollis tincidunt tempus. Duis vitae facilisis enim, at
                                    rutrum lacus. Nam at nisl ut ex egestas placerat sodales id
                                    quam. Aenean sit amet nibh quis lacus pellentesque venenatis
                                    vitae at justo. Orci varius natoque penatibus et magnis dis
                                    parturient montes, nascetur ridiculus mus. Suspendisse
                                    venenatis tincidunt odio ut rutrum. Maecenas ut urna
                                    venenatis, dapibus tortor sed, ultrices justo. Phasellus
                                    scelerisque, nibh quis gravida venenatis, nibh mi lacinia
                                    est, et porta purus nisi eget nibh. Fusce pretium vestibulum
                                    sagittis. Donec sodales velit cursus convallis sollicitudin.
                                    Nunc vel scelerisque elit, eget facilisis tellus. Donec id
                                    molestie ipsum. Nunc tincidunt tellus sed felis vulputate
                                    euismod.
                                </p>
                                <p>
                                    Proin accumsan nec arcu sit amet volutpat. Proin non risus
                                    luctus, tempus quam quis, volutpat orci. Phasellus commodo
                                    arcu dui, ut convallis quam sodales maximus. Aenean
                                    sollicitudin massa a quam fermentum, et efficitur metus
                                    convallis. Curabitur nec laoreet ipsum, eu congue sem. Nunc
                                    pellentesque quis erat at gravida. Vestibulum dapibus
                                    efficitur felis, vel luctus libero congue eget. Donec mollis
                                    pellentesque arcu, eu commodo nunc porta sit amet. In
                                    commodo augue id mauris tempor, sed dignissim nulla
                                    facilisis. Ut non mattis justo, ut placerat justo.
                                    Vestibulum scelerisque cursus facilisis. Suspendisse velit
                                    justo, scelerisque ac ultrices eu, consectetur ac odio.
                                </p>
                                <p>
                                    In pharetra quam vel lobortis fermentum. Nulla vel risus ut
                                    sapien porttitor volutpat eu ac lorem. Vestibulum porta elit
                                    magna, ut ultrices sem fermentum ut. Vestibulum blandit eros
                                    ut imperdiet porttitor. Pellentesque tempus nunc sed augue
                                    auctor eleifend. Sed nisi sem, lobortis eget faucibus
                                    placerat, hendrerit vitae elit. Vestibulum elit orci,
                                    pretium vel libero at, imperdiet congue lectus. Praesent
                                    rutrum id turpis non aliquam. Cras dignissim, metus vitae
                                    aliquam faucibus, elit augue dignissim nulla, bibendum
                                    consectetur leo libero a tortor. Vestibulum non tincidunt
                                    nibh. Ut imperdiet elit vel vehicula ultricies. Nulla
                                    maximus justo sit amet fringilla laoreet. Aliquam malesuada
                                    diam in augue mattis aliquam. Pellentesque id eros
                                    dignissim, dapibus sem ac, molestie dolor. Mauris purus
                                    lacus, tempor sit amet vestibulum vitae, ultrices eu urna.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>

                @include('layouts.footer')
            </div>
        </div>
    </div>

    @include('partials.script')
</body>

</html>

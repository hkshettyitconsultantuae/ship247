// import './bootstrap';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Link } from '@inertiajs/react';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Ship247';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        const toggleMenu = () => {
            document.getElementById("mobile-menu-247").classList.toggle("hidden");
        }
        // Hack to hide Menu again
        setTimeout(function(){
            document.querySelectorAll('#mobile-menu-247 a').forEach(item => {
                item.addEventListener('click', toggleMenu);
            });
        }, 1500)
        root.render(
            <>

                {/* Header */}
                {window.location.pathname.indexOf('/dashboard') === -1 && <header className="max-w-screen-4xl mx-auto">
                    <div className="primary-header default-container">
                        <div className="flex items-center justify-between">
                            <Link href={route('pages.home')} className="header-logo">
                                <img src="/images/ship247-logo-beta.svg" alt="" />
                            </Link>

                            <a href='#' className='mobile-menu' onClick={toggleMenu}>
                                <img src="/images/menu-icon.svg" alt="" />
                                <img src="/images/menu-close-icon.svg" alt="" className='hidden' />
                            </a>

                            <div className="nav-section xl:block hidden" id="mobile-menu-247">
                                <ul className="navigation">
                                    <li>
                                        <Link href={route('pages.benefits')}>benefits</Link>
                                    </li>
                                    <li>
                                        <Link href={route('pages.services')}>services</Link>
                                    </li>
                                    <li>
                                        <Link href={route('pages.resources')}>resources</Link>
                                    </li>
                                    <li>
                                        <Link href={route('pages.work_with_us')}>work with us</Link>
                                    </li>
                                </ul>

                                <div className="login-area">
                                    {/* <a href="#" className="search-icon">
                                    <img src="/images/svg/search-icon.svg" alt="" />
                                </a> */}
                                    {props?.initialPage?.props?.auth?.user == null ?
                                        (
                                            <Link href={route('login')} className="login-icon">
                                                <span className="icon">
                                                    <img src="/images/svg/login-icon.svg" alt="" />
                                                </span>

                                                <span className="text">
                                                    Sign In
                                                </span>
                                                {/* <Link href={route('register')} className='text'>
                                                    register
                                                </Link> */}
                                            </Link>
                                        ) :
                                        (
                                            <div className="login-icon">
                                            <span className="icon">
                                                <img src="/images/svg/login-icon.svg" alt="" />
                                            </span>

                                            <a href={"/dashboard"} className="text">
                                                dashboard
                                            </a>

                                        </div>
                                        )
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </header>}

                <div className="App">
                    <App {...props} />
                </div>


                {/* Footer */}
                {window.location.pathname.indexOf('/dashboard') === -1 && <footer className="primary-footer">
                    <div className="max-w-screen-4xl mx-auto">
                        <div className="default-container">
                            <div className="sm:hidden block mb-10">
                                <div className="logo">
                                    <img src="/images/ship247-logo-white.svg" alt="" />
                                </div>
                            </div>
                            <div className="grid xl:grid-cols-6 sm:grid-cols-3 grid-cols-2 gap-8">
                                <div className="sm:block hidden">
                                    <div className="logo">
                                        <img src="/images/ship247-logo-white.svg" alt="" />
                                    </div>
                                </div>

                                <div className="">
                                    <div className="footer-link">
                                        <h6 className="head">
                                            about
                                        </h6>

                                        <ul className="listing">
                                            <li>
                                                <Link href="/benefits">benefits</Link>
                                            </li>
                                            <li>
                                                <Link href="/news">news</Link>
                                            </li>
                                            <li>
                                                <Link href="/work-with-us">work with us</Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div className="">
                                    <div className="footer-link">
                                        <h6 className="head">
                                            SERVICES
                                        </h6>

                                        <ul className="listing">
                                            <li>
                                                <Link href="#">Customs Clearance</Link>
                                            </li>
                                            <li>
                                                <Link href="#">Surveyor Services</Link>
                                            </li>
                                            <li>
                                                <Link href="/hot-deals">DEALS</Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div className="">
                                    <div className="footer-link">
                                        <h6 className="head">
                                            RESOURCES
                                        </h6>

                                        <ul className="listing">
                                            <li>
                                                <Link href="/resources#loadcalculator">Load Calculator</Link>
                                            </li>
                                            <li>
                                                <Link href="/resources#distancetime">Distance & Time</Link>
                                            </li>
                                            <li>
                                                <Link href="/resources#routeplanner">Route Planner</Link>
                                            </li>
                                            <li>
                                                <Link href="/terms">terms &amp; conditions</Link>
                                            </li>
                                            <li>
                                                <Link href="/policy">privacy policy</Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div className="">
                                    <div className="footer-link">
                                        <h6 className="head">
                                            CONTACT
                                        </h6>

                                        <ul className="contact-list">
                                            <li>
                                                <img src="/images/svg/call-icon.svg" alt="" />
                                                <span>
                                                    +97125469669
                                                </span>
                                            </li>
                                            <li>
                                                <img src="/images/svg/email-icon.svg" alt="" />
                                                <span>
                                                    <a href='mailto:info@ship247.com' className='text-white'>
                                                        info@ship247.com
                                                    </a>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div className="">
                                    <div className="footer-link">
                                        <h6 className="head">
                                            FOLLOW US
                                        </h6>

                                        <ul className="social-media">
                                            <li>
                                                <a href='https://twitter.com/SHIP247WW' target='_blank'>
                                                    <img src="/images/svg/twitter-icon.svg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a href='https://www.linkedin.com/company/ship247/' target='_blank'>
                                                    <img src="/images/svg/linkedin-icon.svg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a href='https://www.instagram.com/ship.247/?igshid=MzRlODBiNWFlZA%3D%3D' target='_blank'>
                                                    <img src="/images/svg/insta-icon.svg" alt="" />
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>}

            </>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

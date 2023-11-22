import {useEffect, useState} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import axios from "axios";

export default function Contact({ status, canResetPassword }) {

    return (
        <GuestLayout>
            <Head title="Contact Us" />

            <section className="max-w-screen-3xl mx-auto">

                <section className="inner-banner default-container">
                    <div className="md:w-5/12">
                        <div className="heading-style-v1">
                            <h2 className="title">Contact</h2>
                            <p className="subtitle">always ready to help 24/7</p>
                        </div>

                        <p className="default-content">
                            For other inquiries please submit your message. Our tea will get back to you in 48 Hrs.
                        </p>
                    </div>

                    <div className="md:w-6/12 ml-auto">
                        <div className='shadow-box md:mt-0 mt-10 small-box'>

                            <form className='default-form'>
                                <div className="grid grid-cols-2 gap-6">
                                    <div className='form-field'>
                                        <InputLabel htmlFor="first name" value="First Name" />

                                        <TextInput
                                            id="first_name"
                                            type="text"
                                            name="first_name"
                                            className="mt-1 block w-full"
                                        />

                                        {/* <InputError message={} className="mt-2" /> */}
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="last name" value="Last Name" />

                                        <TextInput
                                            id="last_name"
                                            type="text"
                                            name="last_name"
                                            className="mt-1 block w-full"
                                        />

                                        {/* <InputError message={} className="mt-2" /> */}
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="email" value="Email" />

                                        <TextInput
                                            id="email"
                                            type="email"
                                            name="email"
                                            className="mt-1 block w-full"
                                        />

                                        {/* <InputError message={} className="mt-2" /> */}
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="phone" value="Phone Number" />

                                        <TextInput
                                            id="phone"
                                            type="phone"
                                            name="phone"
                                            className="mt-1 block w-full"
                                        />

                                        {/* <InputError message={} className="mt-2" /> */}
                                    </div>
                                </div>

                                <div className='form-field mt-8'>
                                    <InputLabel htmlFor="message" value="Message" />

                                    <textarea name="message" id="message" className='form-input w-full resize-none'></textarea>

                                    {/* <InputError message={errors.password} className="mt-2" /> */}
                                </div>

                                <div className="flex items-center mt-4">
                                    
                                    <PrimaryButton className="">
                                        <span>Submit</span>
                                    </PrimaryButton>
                                </div>
                            </form>

                        </div>
                    </div>
                </section>

            </section>
        </GuestLayout>
    );
}

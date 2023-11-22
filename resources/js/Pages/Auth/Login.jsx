import {useEffect, useState} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import axios from "axios";

export default function Login({ status, canResetPassword }) {
    const { data, setData, setError, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [processing, setProcessing] = useState(false)

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = async (e) => {
        e.preventDefault();

        if(!processing) {
            setProcessing(true);
            axios.post(route('login'), data)
                .then(function (response) {
                    window.location.reload();
                })
                .catch(function (error) {
                    if (error?.response?.data?.errors?.email) {
                        setError('email', error?.response?.data?.errors?.email[0]);
                    }
                    setProcessing(false);
                });
        }
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <section className="max-w-screen-md mx-auto">

                <section className="inner-banner flex-col default-container">
                    <div className="w-full text-center">
                        <div className="heading-style-v1">
                            <h2 className="title">sign in</h2>
                            <p className="subtitle">GET ACCESS to a CUSTOM DASHBOARD</p>
                        </div>

                        {/* <p className="default-content">
                            Reduced rates for shipping can lead to lower transportation costs, which can increase profit margins. Companies can pass on the savings to customers or
                        </p> */}
                    </div>

                    <div className="w-full">
                        <div className='shadow-box md:mt-0 mt-10 small-box'>

                            <form onSubmit={submit} className='default-form'>
                                <div className='form-field'>
                                    <InputLabel htmlFor="email" value="Email" />

                                    <TextInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        className="mt-1 block w-full"
                                        autoComplete="username"
                                        isFocused={true}
                                        onChange={(e) => setData('email', e.target.value)}
                                    />

                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                <div className='form-field mt-8'>
                                    <InputLabel htmlFor="password" value="Password" />

                                    <TextInput
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        className="mt-1 block w-full"
                                        autoComplete="current-password"
                                        onChange={(e) => setData('password', e.target.value)}
                                    />

                                    <InputError message={errors.password} className="mt-2" />
                                </div>

                                <div className='form-field checkbox-field mt-8'>
                                    <Checkbox
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) => setData('remember', e.target.checked)}
                                    />
                                    <span className='text'>
                                        Remember me
                                    </span>
                                </div>

                                <div className="flex items-center md:flex-row flex-col-reverse justify-end md:mt-4 mt-8">
                                    {canResetPassword && (
                                        <Link
                                            href={route('password.request')}
                                            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 md:mt-0 mt-4"
                                        >
                                            Forgot your password?
                                        </Link>
                                    )}

                                    <PrimaryButton className="ml-4" disabled={processing}>
                                        <span>{processing ? "Submitting" : "Log in"}</span>
                                    </PrimaryButton>
                                </div>

                                <div className='form-field md:mt-4 mt-8'>
                                    <p className='text-sm md:text-right text-center'>Don't have an account? <Link href={route('register')} className='underline font-bold'>Sign Up</Link></p>
                                </div>
                            </form>

                        </div>
                    </div>
                </section>

            </section>
        </GuestLayout>
    );
}

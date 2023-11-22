import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import CountrySelector from '@/Components/CountrySelector';
import 'react-phone-number-input/style.css'
import PhoneInput from 'react-phone-number-input'
import Checkbox from '@/Components/Checkbox';


export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        country: '',
        phone_number: '',
        email: '',
        company_name: '',
        industry: '',
        vat: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <section className="max-w-screen-md mx-auto">

                <section className="inner-banner flex-col default-container">
                    <div className="w-full text-center">
                        <div className="heading-style-v1">
                            <h2 className="title">SIGNUP</h2>
                            <p className="subtitle">GET ACCESS to a CUSTOM DASHBOARD</p>
                        </div>
                    </div>

                    <div className="w-full">
                        <div className='shadow-box lg:mt-0 mt-10 small-box'>
                            <form onSubmit={submit} className='default-form auth-form'>

                                <section className='grid sm:grid-cols-2 gap-6'>
                                    <div className='form-field'>
                                        <InputLabel htmlFor="first_name" value="First Name" />

                                        <TextInput
                                            id="first_name"
                                            name="first_name"
                                            placeholder="John"
                                            value={data.first_name}
                                            className="mt-1 block w-full"
                                            autoComplete="first_name"
                                            isFocused={true}
                                            onChange={(e) => setData('first_name', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.first_name} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="last_name" value="Last Name" />

                                        <TextInput
                                            id="last_name"
                                            name="last_name"
                                            placeholder="Smith"
                                            value={data.last_name}
                                            className="mt-1 block w-full"
                                            autoComplete="last_name"
                                            onChange={(e) => setData('last_name', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.last_name} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="country" value="Country" />

                                        <CountrySelector id="country"
                                            name="country"
                                            defaultValue={data.country}
                                            className="mt-1 block w-full" required onChange={(e) => setData('country',e.label)}/>

                                        <InputError message={errors.country} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="phone_number" value="Phone Number" />

                                        <PhoneInput
                                            placeholder="Enter phone number"
                                            value={data.phone_number}
                                            className="hs"
                                            onChange={(v)=>setData('phone_number',v)}/>

                                        <InputError message={errors.phone_number} className="mt-2" />

                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="email" value="Email" />

                                        <TextInput
                                            id="email"
                                            type="email"
                                            name="email"
                                            value={data.email}
                                            placeholder="company@domain.com"
                                            className="mt-1 block w-full"
                                            autoComplete="email"
                                            onChange={(e) => setData('email', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.email} className="mt-2" />
                                    </div>

                                    {/* <div className='form-field'>
                                        <InputLabel htmlFor="company_name" value="Company Name" />

                                        <TextInput
                                            id="company_name"
                                            name="company_name"
                                            value={data.company_name}
                                            placeholder="XYZ Ltd."
                                            className="mt-1 block w-full"
                                            autoComplete="company_name"
                                            onChange={(e) => setData('company_name', e.target.value)}
                                        />

                                        <InputError message={errors.company_name} className="mt-2" />
                                    </div> */}

                                    {/* <div className='form-field'>
                                        <InputLabel htmlFor="industry" value="Industry" />

                                        <TextInput
                                            id="industry"
                                            name="industry"
                                            value={data.industry}
                                            placeholder="Select Industry"
                                            className="mt-1 block w-full"
                                            autoComplete="industry"
                                            onChange={(e) => setData('industry', e.target.value)}
                                        />

                                        <InputError message={errors.industry} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="vat" value="VAT" />

                                        <TextInput
                                            id="vat"
                                            name="vat"
                                            value={data.vat}
                                            placeholder="0000-0000-0000"
                                            className="mt-1 block w-full"
                                            autoComplete="vat"
                                            onChange={(e) => setData('vat', e.target.value)}
                                        />

                                        <InputError message={errors.vat} className="mt-2" />
                                    </div> */}

                                    <div className='form-field'>
                                        <InputLabel htmlFor="password" value="Password" />

                                        <TextInput
                                            id="password"
                                            type="password"
                                            name="password"
                                            value={data.password}
                                            placeholder="xxxxxxxxx"
                                            className="mt-1 block w-full"
                                            autoComplete="new-password"
                                            onChange={(e) => setData('password', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.password} className="mt-2" />
                                    </div>

                                    {/* <div className='form-field'>
                                        <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                                        <TextInput
                                            id="password_confirmation"
                                            type="password"
                                            name="password_confirmation"
                                            value={data.password_confirmation}
                                            placeholder="xxxxxxxxx"
                                            className="mt-1 block w-full"
                                            autoComplete="new-password"
                                            onChange={(e) => setData('password_confirmation', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.password_confirmation} className="mt-2" />
                                    </div> */}
                                </section>

                                <div className="form-field checkbox-field mt-8">
                                    <div className="checkbox">
                                        <input type="checkbox" className='form-checkbox' />
                                        <span className="text">I agreed to the <a href="/terms" className='underline'>Terms and Conditions</a></span>
                                    </div>
                                </div>

                                <div className="flex items-center md:flex-row flex-col-reverse justify-end md:mt-4 mt-8">
                                    <PrimaryButton disabled={processing}>
                                        <span>SIGN UP</span>
                                    </PrimaryButton>
                                </div>

                                <div className='form-field md:mt-4 mt-8'>
                                    <p className='text-sm md:text-right text-center'>Already have an account? <Link href={route('login')} className='underline font-bold'>Sign In</Link></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

            </section>

        </GuestLayout>
    );
}

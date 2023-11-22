import GuestLayout from '@/Layouts/GuestLayout';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import {Select} from "antd";
import 'react-phone-number-input/style.css'
import PhoneInput, {isPossiblePhoneNumber} from 'react-phone-number-input'
import InputError from "@/Components/InputError";
import {useRef, useState} from "react";

export default function WorkWithUsForm({industryOptions}) {
    const [isSuccess, setIsSuccess] = useState(false);
    const industrySelectRef = useRef();
    const [isCheckboxChecked, setIsCheckboxChecked] = useState(true);
    // const industryOptions = [
    //     {label: "Insurance", value: "Insurance"},
    //     {label: "Pre Shipment Inspection Service", value: "Pre Shipment Inspection Service"},
    //     {label: "Clearance Agent", value: "Clearance Agent"},
    //     {label: "Transporter/Transport", value: "Transporter/Transport"},
    // ];

    const { data, setData, clearErrors, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        phone_number: '',
        company_name: '',
        industry: [],
    });

    const submit = (e) => {
        e.preventDefault();
        clearErrors();

        // if(!isPossiblePhoneNumber(data.phone_number)) {
        //     errors.phone_number = 'Phone number is not valid';
        //     return false;
        // }

        post(route('work_with_us_forms.store'), {
            preserveScroll: true,
            onSuccess: () => {
                setIsSuccess(true);
                setIsCheckboxChecked(false); // Uncheck the checkbox
                reset();
            },
        })
    };

    return (
        <GuestLayout>
            <Head title="Work With Us" />

            <section className="max-w-screen-xl mx-auto">

                <section className="inner-banner flex-col default-container">
                    <div className="w-full">
                        <div className="heading-style-v1">
                            <h2 className="title">Work With Us</h2>
                            <p className="subtitle">always ready to help 24/7</p>
                        </div>
                    </div>

                    <div className="w-full">
                        <div className='shadow-box md:mt-0 mt-10 small-box'>

                            <form onSubmit={submit} className='default-form'>
                                <div className="grid md:grid-cols-2 gap-6">
                                    <div className='form-field'>
                                        <InputLabel htmlFor="first name" value="First Name" />

                                        <TextInput
                                            id="first_name"
                                            name="first_name"
                                            placeholder="John"
                                            type="text"
                                            className="mt-1 block w-full"
                                            isFocused={true}
                                            onChange={(e) => setData('first_name', e.target.value)}
                                            value={data.first_name}
                                            required
                                        />

                                        <InputError message={errors.first_name} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="last name" value="Last Name" />

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

                                    <div className='form-field'>
                                        <InputLabel htmlFor="phone" value="Phone Number" />
                                        <PhoneInput
                                            placeholder="Enter phone number"
                                            value={data.phone_number}
                                            className="hs"
                                            onChange={(v)=>setData('phone_number',v)}
                                            required/>

                                        <InputError message={errors.phone_number} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="company_name" value="Company Name" />

                                        <TextInput
                                            id="company_name"
                                            name="company_name"
                                            value={data.company_name}
                                            placeholder="XYZ Ltd."
                                            className="mt-1 block w-full"
                                            autoComplete="company_name"
                                            onChange={(e) => setData('company_name', e.target.value)}
                                            required
                                        />

                                        <InputError message={errors.company_name} className="mt-2" />
                                    </div>

                                    <div className='form-field'>
                                        <InputLabel htmlFor="industry" value="Industry" />

                                        <Select
                                            id="industry"
                                            name="industry"
                                            mode="multiple"
                                            ref={industrySelectRef}
                                            allowClear
                                            style={{ width: '100%' }}
                                            placeholder="Select Industry"
                                            options={industryOptions}
                                            value={data.industry}
                                            onChange={(value) => setData('industry', value)}
                                            required
                                        />

                                        <InputError message={errors.industry} className="mt-2" />{/* <InputError message={} className="mt-2" /> */}
                                    </div>

                                    <div className="form-field checkbox-field">
                                        <div className="checkbox">
                                            <input
                                                type="checkbox"
                                                className='form-checkbox'
                                                checked={isCheckboxChecked}
                                                onChange={() => setIsCheckboxChecked(!isCheckboxChecked)} />
                                            <span className="text">I agreed to the <a href="/terms" className='underline'>Terms and Conditions</a></span>
                                        </div>
                                    </div>
                                </div>

                                <div className="flex items-center md:flex-row flex-col-reverse justify-end md:mt-4 mt-8">
                                    <PrimaryButton disabled={processing}>
                                        <span>Submit</span>
                                    </PrimaryButton>
                                </div>

                                {isSuccess && ('Form is submitted Successfully!')}
                            </form>

                        </div>
                    </div>
                </section>

            </section>
        </GuestLayout>
    );
}

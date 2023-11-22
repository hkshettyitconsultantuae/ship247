import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <section className="max-w-screen-3xl mx-auto">

                <section className="inner-banner default-container">
                    <div className="md:w-5/12">
                        <div className="heading-style-v1">
                            <h2 className="title">forgot</h2>
                            <p className="subtitle">GET ACCESS to your password</p>
                        </div>

                        <p className="default-content">
                            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                        </p>
                    </div>

                    <div className="md:w-6/12 ml-auto">
                        <div className='shadow-box small-box'>

                            <form onSubmit={submit} className='default-form'>
                                <div className='form-field'>
                                    <InputLabel htmlFor="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                        onChange={(e) => setData('email', e.target.value)}
                                    />

                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                <div className="mt-8">
                                    <PrimaryButton disabled={processing}>
                                        <span>Email Password Reset Link</span>
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

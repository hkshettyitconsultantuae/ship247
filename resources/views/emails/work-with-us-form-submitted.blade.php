<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ship247</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body style="background-color: #F6F6F6; font-family: 'Figtree', sans-serif; font-size: 16px; margin: 0; padding: 0;">
<div style="max-width: 600px; width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; color: #000000; line-height: 1.5;">
    <table style="width: 100%;">
        <tr>
            <td colspan="2" style="padding-bottom: 30px; font-family: 'Figtree', sans-serif;">
                <img src="{{ asset('/images/logo.png') }}" alt="Ship247 Logo" style="width: 160px; margin: 0 auto;" />
            </td>
        </tr>

        <tr>
            <td colspan="2" style="font-family: 'Figtree', sans-serif;font-size: 18px; text-align: left; line-height: 1.6; border-top: 4px solid #F6F6F6; padding-top: 30px;">
                <span style="font-size: 20px; margin-bottom: 10px; display: block;">Hi,</span>
                An entry for Work with Us form has been submitted with the following details:

                <table>
                    <tbody>
                        <tr>
                            <th>First Name</th>
                            <td>{{ $form->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $form->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>{{ $form->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $form->email }}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{ $form->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Industry</th>
                            <td><ul>
                                    @foreach(explode(',', $form->industry) as $industry)
                                        <li>{{$industry}}</li>
                                    @endforeach
                                </ul></td>
                        </tr>
                    </tbody>
                </table>

            </td>
        </tr>

        <tr>
            <td style="padding-top: 60px;">
                <a href="https://ship247.com" style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #000000;font-family: 'Figtree', sans-serif;">ship247.com</a>
            </td>

            <td style="padding-top: 60px; text-align: right;">
                <a style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #000000; text-decoration: underline;font-family: 'Figtree', sans-serif;" href="tel:+125369963">+12-536-9963</a>
            </td>
        </tr>

    </table>
</div>
</body>
</html>

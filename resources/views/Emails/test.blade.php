<!DOCTYPE html>
<html>

<head>
    <title>Test Mail</title>
</head>

<body>
    <table>

        <tbody>

            <tr>
                <td width='100%' align='center'>
                    @php
                        echo $details['header'];
                    @endphp
                </td>

            </tr>
            <tr>
                <td>
                    @php
                        echo $details['body'];
                    @endphp

                </td>

            </tr>
            <tr>

                <td width='100%' align='center'>
                    @php
                        echo $details['footer'];
                    @endphp

                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>

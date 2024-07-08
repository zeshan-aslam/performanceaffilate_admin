<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
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

                <td width='100%' align='center'> Footer
                    @php
                       echo $details['footer'];
                    @endphp

                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>

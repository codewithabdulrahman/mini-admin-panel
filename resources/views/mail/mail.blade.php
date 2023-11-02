<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
</head>
<body>
    <div>
        <h1>Welcome to our platform!</h1>
        <p>Welcome {{ $company->name }},</p>
        <p>Your company has been successfully created. Here are the details:</p>
        
        <ul>
            <li><strong>Name:</strong> {{ $company->name }}</li>
            <li><strong>Email:</strong> {{ $company->email }}</li>
            <li><strong>Website:</strong> {{ $company->website }}</li>
        </ul>
    </div>
</body>
</html>
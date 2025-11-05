🚀 Serverless Resume Uploader — AWS Hands-On Project
🧭 Overview

This project demonstrates how to build a serverless resume uploader system using AWS.
Users can upload their resumes through an API or a web form. The system stores resumes in S3, logs metadata in DynamoDB, and sends email notifications via SNS — all powered by Lambda and API Gateway.

✅ 100% serverless
✅ Free-tier friendly
✅ Perfect for cloud engineers building a portfolio

🧱 Architecture Overview

AWS Services Used:

Amazon API Gateway – exposes a secure REST API endpoint

AWS Lambda – backend logic for handling uploads

Amazon S3 – stores uploaded resumes

Amazon DynamoDB – stores applicant metadata

Amazon SNS – sends notification emails on new uploads

Amazon CloudWatch – logs and monitoring

S3 Static Website Hosting – for frontend

🗺️ Architecture Diagram

📘 Conceptual Flow:

1.User uploads a resume (via web form or Postman)

2.API Gateway invokes the Lambda function

3.Lambda stores the file in S3

4.Metadata is written to DynamoDB

5.SNS sends a notification email

6.CloudWatch logs the entire flow

Step-by-Step Implementation of the architecture
Phase 1 — Core Infrastructure

1️⃣ Create S3 Bucket (for resumes)

Go to S3 → Create bucket

Give your s3 bucket a unique name

Disable “Block all public access”

Click Create bucket

2️⃣ Create DynamoDB Table (for metadata)

Go to DynamoDB → Tables → Create table

Table name: Applicants

Partition key: email (String)

Keep defaults → Create

3️⃣ Create SNS Topic (for notifications)

Go to SNS → Topics → Create topic

Type: Standard

Name: resumeNotifications

Create a subscription:

Protocol: Email

Endpoint: your email

Confirm the email from your inbox

Phase 2 — Lambda Function Setup and permissions

Your Lambda needs permission to access S3, DynamoDB, and SNS.

Go to IAM → Roles → Create role

Choose Trusted entity: AWS Service → Lambda

Click Next

Under Permissions, attach these AWS-managed policies:

--AmazonS3FullAccess
--AmazonDynamoDBFullAccess
--AmazonSNSFullAccess
--CloudWatchLogsFullAccess

Click Next

Name: lambda-resume-uploader-role

Create role

✅ This gives your Lambda all the access it needs

4️⃣ Create Lambda Function
Go to Lambda → Create function

Name: resumeUploader

Runtime: Python 3.12

Role: Create new role with basic Lambda permissions

5️⃣ Add Environment Variables

Under Configuration → Environment variables, add:

Key: Value:
S3_BUCKET your S3 bucket name
TABLE_NAME Applicants
SNS_TOPIC_ARN ARN of your SNS topic

6️⃣ Add Code
Check lambda_function.py in the project folder
Deploy your code.

Phase 3 — API Gateway Integration
7️⃣ Create API
Go to API Gateway → Create API

Choose REST API → Build

Name: ResumeUploaderAPI

8️⃣ Add Resource

Resource path: /resumes

9️⃣ Add Method

Method: POST

Integration type: Lambda Function

Function name: resumeUploader

Enable Lambda proxy integration

🔟 Enable CORS

For /resumes, click Actions → Enable CORS

Allow POST and OPTIONS

Deploy API to stage: prod

Phase 4 — Testing
Test via Postman:

POST → https://your-api-id.execute-api.us-east-1.amazonaws.com/prod/resumes

Headers:

Content-Type: application/json

Body (raw JSON):

{
"name": "Elijah Okello",
"email": "elijah@example.com",
"position": "Cloud Engineer",
"resume": "c29tZSByZXN1bWU="
}

--Expected Response:

{
"message": "Resume uploaded successfully!"
}

Check:
S3: file uploaded
DynamoDB: new entry
Email: SNS notification received

Phase 5 — Frontend Hosting
1️⃣ Create website bucket

Name: resume-uploader-site-yourname

Disable “Block all public access”

2️⃣ Enable static website hosting

Index document: index.html

Note the website endpoint URL

3️⃣ Upload your HTML file

Replace API URL(code for the site in project folder)

4️⃣ Update your bucket policy
Allow public read:

{
"Effect": "Allow",
"Principal": "_",
"Action": "s3:GetObject",
"Resource": "arn:aws:s3:::resume-uploader-site-yourname/_"
}
Visit your website endpoint URL to view your website, upload a resume to test if its working.

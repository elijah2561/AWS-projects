import json
import boto3
import base64
import time
import uuid
import os

s3 = boto3.client('s3')
dynamodb = boto3.resource('dynamodb')
sns = boto3.client('sns')

def lambda_handler(event, context):
    try:
        body = json.loads(event['body'])

        name = body['name']
        email = body['email']
        position = body['position']
        resume_file = body['resume']
        file_bytes = base64.b64decode(resume_file)

        bucket = os.environ['S3_BUCKET']
        table_name = os.environ['TABLE_NAME']
        topic_arn = os.environ['SNS_TOPIC_ARN']

        # Create unique filename
        file_name = f"{email}-{uuid.uuid4()}.pdf"

        # Upload to S3
        s3.put_object(Bucket=bucket, Key=file_name, Body=file_bytes)

        # Save metadata in DynamoDB
        table = dynamodb.Table(table_name)
        table.put_item(Item={
            'email': email,
            'name': name,
            'position': position,
            'resume_url': f"https://{bucket}.s3.amazonaws.com/{file_name}",
            'timestamp': int(time.time())
        })

        # Send notification via SNS
        sns.publish(
            TopicArn=topic_arn,
            Subject="New Resume Uploaded",
            Message=f"{name} ({email}) applied for {position}."
        )

        return {
            "statusCode": 200,
            "body": json.dumps({"message": "Resume uploaded successfully!"})
        }

    except Exception as e:
        print("Error:", str(e))
        return {
            "statusCode": 500,
            "body": json.dumps({"error": str(e)})
        }

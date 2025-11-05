OKELLO ELIJAH
https://www.linkedin.com/in/okello-elijah-5bb745201
Project: Deploying a Web Application on AWS Fargate
Overview

I worked on a cloud deployment project to host a simple web application called “Movie Night” a platform that allows members of a local cinema to vote on which movie should premiere each month.
The project demonstrates the use of several AWS services to build a secure, scalable, and containerized application deployment.

AWS Services Used

• Amazon VPC – Custom networking environment with public and private subnets

• Amazon ECS (Fargate) – Serverless container orchestration

• Amazon ECR – Container image repository

• Amazon RDS (MySQL) – Managed relational database service

• Amazon Secrets Manager – Secure management of application credentials

• Amazon EC2 – Used as a Docker build server

• AWS Lambda – Automatic credential rotation for Secrets Manager

Architecture

A detailed architecture diagram illustrates the complete setup including the VPC, ALB, ECS cluster, and database tier showing secure communication flows between components
.
Implementation Steps

1. VPC Setup

• Created a custom VPC with 6 subnets: 2 public and 4 private.

• Attached an Internet Gateway, configured a NAT Gateway, and set up appropriate route tables.

• Defined three security groups to control traffic flow:

o mn-alb-sg — Allows inbound HTTP traffic from the internet.

o mn-app-sg — Allows inbound HTTP traffic from the ALB security group.

o mn-data-sg — Allows inbound MySQL traffic from the app security group.

2. ECR Repository

Created a private repository in Amazon ECR to store and manage container images securely.

3. Docker Image Build

• Launched an EC2 instance as a dedicated Docker build server.

• Assigned an IAM role to allow interaction with ECR.

• Installed Docker, built the application image, and verified its functionality locally.

4. Push Image to ECR

Authenticated to ECR and pushed the Docker image to the repository for later use in ECS tasks.

5. Database Setup (RDS MySQL)

• Defined subnet groups for database placement within private subnets.

• Deployed an RDS MySQL instance with multi-AZ capability for high availability.

6. Secrets Management

• Configured AWS Secrets Manager to securely store database credentials.

• Enabled automatic key rotation via a Lambda function, reducing manual overhead and improving security posture.

7–8. Load Balancer Configuration

• Created a target group for ECS tasks.

• Deployed an Application Load Balancer (ALB) in the public subnets to distribute inbound traffic across containers running on Fargate.

9. IAM Roles and Policies

• Created a custom IAM policy (movie-night-allow-read-db-secrets-policy) to grant ECS tasks permission to read secrets.

• Created an ECS Task Role and attached:

o AmazonECSTaskExecutionRolePolicy (managed)

o Custom secrets access policy

10. ECS Cluster (Fargate)

Created an ECS cluster configured to use AWS Fargate, allowing fully managed, serverless container execution.

11. Task Definition

Defined a task definition specifying:

• Launch type (Fargate)

• Container image (from ECR)

• Port mappings

• IAM roles

• Environment variables and secrets references

12. ECS Service Deployment

• Configured the ECS service for deployment, networking, load balancing, and auto-scaling.

• Verified that containers were successfully deployed to the cluster and accessible via the ALB endpoint.

Outcome

The deployment successfully delivered a secure, fully managed, and scalable containerized web application on AWS Fargate, integrating best practices for networking, secrets management, and load balancing.

<?php
// Konfigurasi Database PostgreSQL Supabase
// Mendukung Environment Variables (Vercel) dan fallback kredensial default
$host     = getenv('SUPABASE_HOST') ?: "aws-0-ap-northeast-1.pooler.supabase.com";
$port     = getenv('SUPABASE_PORT') ?: "5432"; // Supabase Session pooler port
$database = getenv('SUPABASE_DB') ?: "postgres";
$username = getenv('SUPABASE_USER') ?: "postgres.dpuetzbypujalrtejmiu";
$password = getenv('SUPABASE_PASSWORD') ?: "OzygCW88EbSHexBB";

$conn_str = "host=$host port=$port dbname=$database user=$username password=$password sslmode=require";
$conn = @pg_connect($conn_str);

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}
?>
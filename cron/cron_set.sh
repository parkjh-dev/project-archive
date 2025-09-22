systemctl status crond
systemctl enable crond
systemctl start crond

echo '0 9 * * * root /project/cron/filter_cron.sh' >> /etc/crontab # 필터(국방부/국어원) 업데이트 (매일 09시)
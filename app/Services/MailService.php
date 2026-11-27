<?php
namespace App\Services;

use App\Models\User;
use Core\Logging\Logger;
use Core\Support\Env;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envio de e-mails transacionais via SMTP (PHPMailer).
 *
 * Configurado por variáveis de ambiente (MAIL_*). Quando MAIL_HOST não está
 * definido, o e-mail não é enviado: o conteúdo é registrado no log e a chamada
 * devolve `false`. Assim o projeto continua portável, sem exigir SMTP em dev.
 */
class MailService {
    /**
     * Envia um e-mail HTML. Devolve `true` em caso de sucesso.
     */
    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $host = trim((string) Env::get('MAIL_HOST', ''));

        if ($host === '') {
            Logger::instance()->warning('E-mail não enviado: MAIL_HOST não configurado', [
                'to' => $to,
                'subject' => $subject,
                'body' => $textBody !== '' ? $textBody : $htmlBody,
            ]);
            return false;
        }

        $mailer = new PHPMailer(true);

        try {
            $username = (string) Env::get('MAIL_USERNAME', '');
            $encryption = strtolower(trim((string) Env::get('MAIL_ENCRYPTION', '')));

            $mailer->isSMTP();
            $mailer->Host = $host;
            $mailer->Port = (int) Env::get('MAIL_PORT', 587);
            $mailer->CharSet = 'UTF-8';
            $mailer->SMTPAuth = $username !== '';

            if ($mailer->SMTPAuth) {
                $mailer->Username = $username;
                $mailer->Password = (string) Env::get('MAIL_PASSWORD', '');
            }

            if ($encryption === 'ssl' || $encryption === 'smtps') {
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls' || $encryption === 'starttls') {
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $from = trim((string) Env::get('MAIL_FROM_ADDRESS', ''));
            if ($from === '') {
                $from = $username !== '' ? $username : 'no-reply@localhost';
            }
            $fromName = (string) Env::get('MAIL_FROM_NAME', (string) Env::get('APP_NAME', 'BugLivre'));

            $mailer->setFrom($from, $fromName);
            $mailer->addAddress($to);
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body = $htmlBody;
            $mailer->AltBody = $textBody !== '' ? $textBody : strip_tags($htmlBody);

            $mailer->send();

            return true;
        } catch (PHPMailerException $e) {
            Logger::instance()->error('Falha ao enviar e-mail', [
                'to' => $to,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Envia o link de redefinição de senha para o usuário.
     */
    public function sendPasswordResetLink(User $user, string $resetUrl): bool {
        $appName = (string) Env::get('APP_NAME', 'BugLivre');
        $name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8');
        $safeApp = htmlspecialchars($appName, ENT_QUOTES, 'UTF-8');

        $html = '<p>Olá, ' . $name . '!</p>'
            . '<p>Recebemos um pedido para redefinir a senha da sua conta no ' . $safeApp . '.</p>'
            . '<p><a href="' . $url . '">Redefinir minha senha</a></p>'
            . '<p>Se você não solicitou, ignore este e-mail. O link expira em breve.</p>'
            . '<p>— ' . $safeApp . '</p>';

        $text = "Olá, {$user->name}!\n\n"
            . "Recebemos um pedido para redefinir a senha da sua conta no {$appName}.\n"
            . "Acesse o link para criar uma nova senha:\n{$resetUrl}\n\n"
            . "Se você não solicitou, ignore este e-mail.\n";

        return $this->send($user->email, 'Redefinição de senha · ' . $appName, $html, $text);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssessmentCompleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $assessment;
    public $finalScore;

    public function __construct($user, $assessment, $finalScore)
    {
        $this->user = $user;
        $this->assessment = $assessment;
        $this->finalScore = $finalScore;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
              from: 'Employee Assessment Platform <no-reply@example.com>',
              subject: 'Assessment Completed Notification'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.assessment-completed', // Ensure this view exists
            with: [
                'user' => $this->user,
                'assessment' => $this->assessment,
                'finalScore' => $this->finalScore
            ]
        );
    }

    public function attachments(): array
    {
        // Add attachments here if needed
        return [];
    }

    public function headers(): array
    {
        // Add custom headers here if needed
        return [];
    }
}
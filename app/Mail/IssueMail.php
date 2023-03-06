<?php

namespace App\Mail;

//imoport models
use App\Models\Acoes;
//imoportar outros controllers
use App\Http\Controllers\AcoesController;
//outros imports
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssueMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    //construtor, sempre que queremos criar um mail, temos de enviar uma ação, quem criou, uma mensagem(nova issue, update etc,e um subject)
    public function __construct(Acoes $acao,$createdby,$messages,$sub)
    {
        //binding para o objecto
        $this->acao=$acao;
        $this->messages=$messages;
        $this->createdby=$createdby;
        $this->sub=$sub;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    //construir o email
    public function build()
    {

        //obter email do responsavel
        $mailTo=AcoesController::getMail($this->acao->number_responsible);
        //obter o nome do responsavel
        $nameTo=AcoesController::getName($this->acao->number_responsible);
        //definir a quem enviar
        $this->to($mailTo,$nameTo);
        //definir assunto do email
        $this->subject($this->sub);
        //definir quem envia
        $this->from('gam2.0@zf.com', 'GAM2.0');
        $link = "http://gamv2.po1.ad.trw.com:8080/acoes/details/".$this->acao->idissue;
        //mandar informacao para a view
        return $this->view('mail2.default')
        ->with([
            'createdby' => $this->createdby,
            'messages' => $this->messages,
            'acao'=>$this->acao,
            'link'=> $link

        ]);
    }
}

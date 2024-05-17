<?php

namespace App\Http\Resources;

use App\Models\Promotor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Promotor
 */
class PromotorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'nome' => $this->nome,
        ];
        // CAMPOS DA TABELA
        //"id" => 1817
        //"nome" => "CLARISSE LINDANOR ALCANTARA LAX"
        //"matricula" => "10101"
        //"login_ecidade" => "clarisse.alcantara"
        //"senha_ecidade" => null
        //"login_intranet" => "clarisse.alcantara"
        //"senha_intranet" => "$1$TliWUOw6$BzJusEqXQ7.6d6RBWHQbX/"
        //"login_urano" => "82672040249"
        //"senha_urano" => "1fe7d3b6f010b014ae9d0c33dd5700b4"
        //"login_ad" => "clarisse.alcantara"
        //"senha_ad" => null
        //"email" => "clarisse.alcantara@mpap.mp.br"
        //"cpf" => "82672040249"
        //"rg" => "209953"
        //"id_urano" => "253"
        //"id_ecidade" => "441"
        //"status" => "1"
        //"ultimo_acesso" => "2024-04-16 16:04:39"
        //"ultimo_acesso_sistema" => "Intranet"
        //"objectguid_ad" => "A2A0856F-0A97-49AF-BE52-1B595BCE1AC3"
        //"cgm_ecidade" => "3095"
        //"expiracao_senha_ad" => null
        //"data_admissao" => "2015-09-25"
        //"data_rescisao" => null
        //"categoria" => "M"
        //"token_api" => "4b03efe0-3661-4264-a587-d637148d8b01"
        //"foto_intranet" => "uploads/avatars/2020_07/6b173064f438f5d126666bbb37a4ce39f62cb77e.jpg"
        //"google_auth_token" => null
    }
}

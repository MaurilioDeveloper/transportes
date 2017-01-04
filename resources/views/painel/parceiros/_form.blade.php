{!! Form::hidden('pessoa', $pessoa, ['id' => 'pessoa']) !!}

<div class="form-group col-md-6">
    <label for="Nome">Nome *</label>
    {!! Form::text('nome', null, ['class' => 'form-control', 'required' => 'true']) !!}
</div>

<div class="form-group col-md-6">
    {!! Form::label('documento', $pessoa == \App\Parceiro::PESSOA_JURIDICA ? 'CNPJ': 'CPF') !!}
    @if($pessoa == \App\Parceiro::PESSOA_JURIDICA)
        {!! Form::text('documento', null, ['class' => 'form-control', 'id' => 'cnpj']) !!}
    @else
        {!! Form::text('documento', null, ['class' => 'form-control', 'id' => 'cpf']) !!}
    @endif
    {{--        {!! Form::text('documento', null, ['class' => 'form-control']) !!}--}}
</div>

<div class="form-group col-md-6">
    {!! Form::label('email', 'E-mail') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('telefone', 'Telefone') !!}
    {!! Form::text('telefone', null, ['class' => 'form-control', 'id' => 'phone']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('cep', 'CEP') !!}
    {!! Form::text('cep', null, ['class' => 'form-control', 'id' => 'cep']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('endereco', 'Endereço') !!}
    {!! Form::text('endereco', null, ['class' => 'form-control', 'id' => 'rua']) !!}
</div>

<div class="form-group col-md-6">
    {!! Form::label('numero', 'Número') !!}
    {!! Form::text('numero', null, ['class' => 'form-control', 'id' => 'numero']) !!}
</div>

<div class="form-group col-md-6">
    {!! Form::label('complemento', 'Complemento') !!}
    {!! Form::text('complemento', null, ['class' => 'form-control', 'id' => 'complemento']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('bairro', 'Bairro') !!}
    {!! Form::text('bairro', null, ['class' => 'form-control', 'id' => 'bairro']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('cidade', 'Cidade *') !!}
    {!! Form::text('cidade', null, ['class' => 'form-control', 'id' => 'cidade']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('estado', 'Estado') !!}
    {!! Form::text('estado', null, ['class' => 'form-control', 'id' => 'state']) !!}
</div>


<div class="form-group col-md-6">
    {!! Form::label('site', 'Site') !!}
    {!! Form::text('site', null, ['class' => 'form-control']) !!}
</div>

@if($pessoa == \App\Parceiro::PESSOA_JURIDICA)
    <div class="form-group col-md-6">
        {!! Form::label('fantasia', 'Fantasia') !!}
        {!! Form::text('fantasia', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('inscricao_estadual', 'Inscrição Estadual') !!}
        {!! Form::text('inscricao_estadual', null, ['class' => 'form-control']) !!}
    </div>
@else
    <div class="form-group col-md-6">
        {!! Form::label('estado_civil', 'Estado Civil') !!}
        {!! Form::select('estado_civil', array_merge([0 => 'Selecione'],\App\Parceiro::ESTADOS_CIVIS), null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-md-6">

        {!! Form::label('data_nasc', 'Data Nascimento') !!}
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
{{--            {!! Form::input('data_nasc', null , ['class' => 'form-control pull-right', 'id' => '']) !!}--}}
            <input type="text" class="form-control datapicker pull-right" name="data_nasc" value="@if(isset($data_nasc)){{$data_nasc}}@else {{old('data_nasc')}}@endif"/>
        </div>

    </div>


    <div class="form-group col-md-3" style="margin-top: 30px">
        <label>
            <div class="iradio_flat-green hover" aria-checked="false"
                 aria-disabled="false">{!! Form::radio('sexo', 'm', true, ['class' => 'flat-red']) !!}
                <ins class="iCheck-helper"></ins>
            </div>
            Masculino
        </label>
    </div>

    <div class="form-group col-md-3" style="margin-top: 30px">
        <label>
            <div class="iradio_flat-green hover" aria-checked="false"
                 aria-disabled="false">{!! Form::radio('sexo', 'f', false, ['class' => 'flat-red']) !!}
                <ins class="iCheck-helper"
                     style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
            </div>
            Feminino
        </label>
    </div>

@endif
<div style="display: none;" id="dialog-confirm" title="Deletar">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 12px 20px 0; "></span>Deseja realmente excluir esse Contato?</p>
</div>
<div class="form-group col-md-12">
    <div class="box box-primary collapsed-box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Contato</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="box-body">
                <input type="hidden" name="count" value="0"/>
                {{--<div id="fields">--}}
                <div id="campos">
                    <div id="id" class="row">
                        {{--<div class="principal">--}}
                        <?php $i=0;?>
                    @if(isset($parceiro->id) && ($parceiro->id > 0) && (count($contatos) > 0))
                            @foreach ($contatos as $contato)
                                {{--<input type="hidden" value="{{$i}}" class="count" />--}}
                                <div id="column-{{$i}}">
                                <input type="hidden" id="id-contato" value="{{$contato->id}}" name="extras[{{$i}}][id]"/>
                                    <div class="form-group col-md-3">
                                        <label for="nome">Nome </label>
                                        <input type="text" name="extras[{{$i}}][nome]" class="form-control" id="nome" placeholder="Nome" value="@if(isset($contato->nome)){{$contato->nome}}@else{{old('extras[0][modelo]')}}@endif">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Setor </label>
                                        <input type="text" name="extras[{{$i}}][setor]" class="form-control" placeholder="Setor" value="@if(isset($contato->setor)){{$contato->setor}}@else{{old('extras[0][setor]')}}@endif">
                                    </div>
                                    <!-- /.form group -->
                                    <div class="form-group col-md-3">
                                        <label for="email">Email </label>
                                        <input type="email" name="extras[{{$i}}][email]" class="form-control"
                                               placeholder="example@email.com" value="@if(isset($contato->email)){{$contato->email}}@else{{old('extras[0][email]')}}@endif">
                                    </div>
                                    <div class="form-group  col-md-2">
                                        <label for="telefone">Telefone </label>
                                        <input type="text" name="extras[{{$i}}][telefone]" class="form-control phone"  value="@if(isset($contato->telefone)){{$contato->telefone}}@else{{old('extras[0][telefone]')}}@endif">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label><hr/></label>
                                        <a class="btn btn-danger btn-sm" onclick="removerContato({{$i}})"/><i class="fa fa-trash"></i></a>
                                    </div>
                                    {{--<div class="col-md-12"><hr style="border: 1px solid #ccc"/></div>--}}
                                    </div>
                                    <?php $i++ ?>
                                @endforeach
                                {{--<hr style="border: 1px solid #ccc"/>--}}
                            @else
                                <div class="form-group col-md-3">
                                        <label for="nome">Nome </label>
                                        <input type="text" name="extras[0][nome]" class="form-control" id="nome" placeholder="Nome">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Setor </label>
                                        <input type="text" name="extras[0][setor]" class="form-control" placeholder="Setor">
                                    </div>
                                    <!-- /.form group -->
                                    <div class="form-group col-md-3">
                                        <label for="cidade_reg">Email </label>
                                        <input type="email" name="extras[0][email]" class="form-control"
                                               placeholder="example@email.com">
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label for="telefone">Telefone </label>
                                        <input type="text" name="extras[0][telefone]" class="form-control phone">
                                    </div>
                                {{--<hr style="border: 1px solid #ccc"/>--}}

                            @endif
                            {{--</div>--}}
                        </div>

                </div>
                <input type="hidden" class="count-contato" value="{{$i}}" />
                <button type="button" class="btn btn-success add-more" id="add-more"><i
                            class="fa fa-plus-square"></i>&nbsp;&nbsp;Adicionar
                    Contato(s)
                </button>
            </div>
        </div><!-- /.box-body -->
    </div>
</div>


<div class="form-group col-md-12">
    <div class="box box-primary collapsed-box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Caminhões</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="box-body">
                {{--<input type="hidden" name="count" value="0"/>--}}
                {{--<div id="fields">--}}
                <div id="camposCaminhoes">
                    <div id="idCaminhao">
                        @if(isset($parceiro->id) && ($parceiro->id > 0)  && (count($caminhoes) > 0))
                            <?php $i=0;?>
                            @foreach ($caminhoes as $caminhao)
                                <div id="caminhao-{{$i}}">
                                <input type="hidden" value="{{$caminhao->id}}" name="extraCaminhoes[{{$i}}][id]"/>
                                    <div class="form-group col-md-4">
                                        <label>Placa </label>
                                        <input type="text" class="form-control" name="extraCaminhoes[{{$i}}][placa]"
                                               placeholder="AAA-9999"
                                               value="@if(isset($caminhao->placa)){{$caminhao->placa}}@else{{old('extraCaminhoes[0][placa]')}}@endif">
                                    </div>
                                    <!-- /.form group -->
                                    <div class="form-group col-md-4">
                                        <label for="modelo">Modelo </label>
                                        <input type="text" class="form-control" name="extraCaminhoes[{{$i}}][modelo]"
                                               placeholder="Modelo"
                                               value="@if(isset($caminhao->modelo)){{$caminhao->modelo}}@else{{old('extraCaminhoes[0][modelo]')}}@endif">
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label for="cor">Cor </label>
                                        <input type="text" class="form-control" name="extraCaminhoes[{{$i}}][cor]" placeholder="Azul"
                                               value="@if(isset($caminhao->cor)){{$caminhao->cor}}@else{{old('extraCaminhoes[0][cor]')}}@endif">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label><hr/></label>
                                        <a class="btn btn-danger btn-sm" onclick="removerCaminhao({{$i}})"/><i class="fa fa-trash"></i></a>
                                    </div>
                                    </div>

                                <?php $i++;?>
                                @endforeach

                    @else
                        <div class="form-group col-md-4">
                            <label>Placa </label>
                            <input type="text" class="form-control" name="extraCaminhoes[0][placa]"
                                   placeholder="AAA-9999"
                                   value="">
                        </div>
                        <!-- /.form group -->
                        <div class="form-group col-md-4">
                            <label for="modelo">Modelo </label>
                            <input type="text" class="form-control" name="extraCaminhoes[0][modelo]"
                                   placeholder="Modelo"
                                   value="">
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="cor">Cor </label>
                            <input type="text" class="form-control" name="extraCaminhoes[0][cor]" placeholder="Azul"
                                   value="">
                        </div>
                            {{--<div class="col-md-12"><hr style="border: 1px solid #ccc"/></div>--}}
                     @endif
                </div>
                </div>
                <input type="hidden" class="count-caminhao" value="{{$i}}" />
                <button type="button" class="btn btn-success add-caminhao" id="add-caminhao"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Adicionar
                    Caminhão (es)
                </button>
            </div>
        </div><!-- /.box-body -->
    </div>
</div>


<div class="form-group col-md-12">
    <div class="box box-primary collapsed-box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Motoristas</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">


            <!-- form start -->
            {{--<form role="form">--}}
                <div class="box-body">
                    <div id="camposMotorista">
                        <div id="idMotorista">

                            @if(isset($parceiro->id) && ($parceiro->id > 0) && (count($motoristas) > 0))
                                <?php $i=0;?>

                            {{--{{$motoristas}}--}}
                                @foreach ($motoristas as $motorista)
                                    <div id="motorista-{{$i}}">
                                    <input type="hidden" value="{{$motorista->id}}" name="extraMotoristas[{{$i}}][id]"/>
                                    {{--{{$parceiro->id}}--}}
                                    <div class="form-group col-md-4">
                                        <label for="extraMotoristas[{{$i}}][nome]">Nome </label>
                                        <input type="text" class="form-control" name="extraMotoristas[{{$i}}][nome]"
                                               placeholder="Nome" value="@if(isset($motorista->nome)){{$motorista->nome}}@else{{old('extraMotoristas[0][nome]')}}@endif">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="extraMotoristas[{{$i}}][rg]">RG </label>
                                        <input type="text" class="form-control" name="extraMotoristas[{{$i}}][rg]" value="@if(isset($motorista->rg)){{$motorista->rg}}@else{{old('extraMotoristas[0][rg]')}}@endif">
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label for="extraMotoristas[{{$i}}][telefone]">Telefone </label>
                                        <input type="text" class="form-control phone" name="extraMotoristas[{{$i}}][telefone]" value="@if(isset($motorista->telefone)){{$motorista->telefone}}@else{{old('extraMotoristas[0][telefone]')}}@endif"
                                               id="telefone">
                                    </div>
                                        <div class="form-group col-md-1">
                                            <label><hr/></label>
                                            <a class="btn btn-danger btn-sm" onclick="removerMotorista({{$motorista->id}})"/><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                    <?php $i++;?>
                                    {{--<hr/>--}}
                                @endforeach
                                {{--{{$motoristas}}--}}
                            @else

                                <div class="form-group col-md-4">
                                    <label>Nome </label>
                                    <input type="text" class="form-control" name="extraMotoristas[0][nome]"
                                           placeholder="Nome">
                                </div>
                                <!-- /.form group -->
                                <div class="form-group col-md-4">
                                    <label for="cidade_reg">RG </label>
                                    <input type="text" class="form-control" name="extraMotoristas[0][rg]" placeholder="RG">
                                </div>
                                <div class="form-group  col-md-4">
                                    <label for="telefone">Telefone </label>
                                    <input type="text" class="form-control phone" name="extraMotoristas[0][telefone]"
                                           id="telefone">
                                </div>
                                {{--<div class="col-md-12">--}}
                                    {{--<hr style="border: 1px solid #ccc"/>--}}
                                {{--</div>--}}
                            @endif
                            </div>

                    </div>
                    <input type="hidden" class="count-motorista" value="{{$i}}" />
                    <button type="button" class="btn btn-success add-motorista" id="add-motorista"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Adicionar
                        Motorista(s)
                    </button>

                </div>
            {{--</form><!-- /.box-body -->--}}
        </div><!-- /.box-body -->
    </div>
</div>

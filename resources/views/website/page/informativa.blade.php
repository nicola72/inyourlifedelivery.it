@extends('layouts.website')
@section('content')
    <div id="main-page" class="col-md-12" style="background-color:#fff;padding-top:140px;padding-bottom:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    INFORMATIVA AI SENSI DELL’ART. 13 DEL D. LGS. 30 GIUGNO 2003 N. 196 E DEL GDPR Regolamento Europeo 2016/679 Titolare del trattamento dei dati personali.

                    {{$shop->ragione_sociale}} - {{$shop->indirizzo}},{{$shop->nr_civico}} {{$shop->cap}} {{$shop->citta}} {{$shop->provincia}}
                    è titolare del trattamento dei dati personali. Finalità del trattamento. I dati personali forniti
                    sono trattati nell’ambito della normale attività di  {{$shop->ragione_sociale}} secondo le seguenti finalità:
                    per dare esecuzione alla richiesta che l’utente sta compiendo; per esigenze di tipo operativo e gestionale;
                    per effettuare analisi statistiche; per ottemperare agli obblighi di legge; I trattamenti saranno effettuati
                    con l’ausilio di mezzi elettronici o comunque automatizzati e comprendono, nel rispetto dei limiti e delle condizioni
                    poste dall’art. 11 del D. Lgs. 196/2003, tutte le operazioni o complesso di operazioni previste dallo stesso decreto
                    con il termine “trattamento”. Natura del trattamento. Il conferimento dei dati personali ha natura facoltativa.
                    Tuttavia il mancato conferimento, anche parziale, dei dati richiesti nei campi contrassegnati da un asterisco
                    determinerà l’impossibilità di inoltrare la richiesta e di procedere all’erogazione dei servizi offerti. Comunicazione
                    e diffusione dei dati. I dati raccolti non saranno oggetto di diffusione o comunicazione a terzi se non nei casi
                    previsti dall’informativa e/o dalla legge e comunque con le modalità da questa consentite. Diritti dell’interessato.
                    Ai sensi dell’art. 7 del D. Lgs. N. 196/03 l’interessato ha diritto ad ottenere l’indicazione: della conferma dell’esistenza o
                    meno di dati personali che lo riguardano e della loro comunicazione in forma intelligibile, dell’origine dei
                    dati personali, delle finalità e delle modalità del trattamento, della logica applicata in caso di trattamento
                    effettuato con l’ausilio di strumenti elettronici, degli estremi identificativi del titolare, dei soggetti ai quali
                    i dati possono essere comunicati. L’interessato ha diritto di ottenere: l’aggiornamento, la rettificazione ovvero, quando
                    vi ha interesse, l’integrazione dei dati, la cancellazione, la trasformazione in forma anonima o il blocco
                    dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la conservazione in relazione agli
                    scopi per i quali sono stati raccolti o successivamente trattati; l’interessato ha diritto di opporsi per motivi
                    legittimi al trattamento dei dati personali che lo riguardano anche ai fini dell’invio di materiale pubblicitario,
                    di vendita diretta o per ricerche di mercato o di comunicazione commerciale. Per esercitare i suddetti diritti l'interessato
                    può scrivere a, <a href="mailto:{{$shop->email}}">{{$shop->email}}</a>
                    o telefonare al numero {{$shop->telefono}}.<br>
                    I contenuti saranno trattati esclusivamente per finalità inerenti l'attività aziendale fino ad esplicita
                    richiesta di cancellazione da parte dell'interessato secondo articolo 13 comma 2 lettera A.
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>

    </script>
@stop
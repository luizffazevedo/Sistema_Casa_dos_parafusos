/**
 * This content is released under the MIT License (MIT)
 *
 * @author      AteZ Development Team <@AteZBR>
 * @copyright   (c) AteZ Trading Ltda.
 * @license     https://www.atez.com.br/license    MIT License
 * @link        https://www.atez.com.br
 */
!(function () {
  "use strict";
  if ("undefined" === typeof jQuery) {
    throw new Error("Application requires jQuery library");
    exit(0);
  }
})(this),
  +(function () {
    "use strict";
  })(jQuery);
$(".btnAumentarTextBox").on("click", function () {
  textArea = $(event.target)
    .parent()
    .parent()
    .children("div")
    .children("textarea")
    .css("height", "+=200");
  $(textArea).css("min-height", "+=50");
});

$(".btnDiminuirTextBox").on("click", function () {
  textArea = $(event.target)
    .parent()
    .parent()
    .children("div")
    .children("textarea")
    .css("height", "+=200");
  $(textArea).css("min-height", "-=50");
});

$(document).ready(function () {
  //Esse trecho esconde ou mostra a Logo acima do menu
  sidebarminify = getCookie("sidebar-minified");  
  if(sidebarminify == 'true'){
    $(".image-logo-top").addClass("hide");
  }else{
    $(".image-logo-top").removeClass("hide");
  }
  $('.sidebar-minify-btn').bind("click",function(evt){
    if(sidebarminify == 'true'){
      $(".image-logo-top").removeClass("hide");
      sidebarminify = 'false'
    }else{
      $(".image-logo-top").addClass("hide");
      sidebarminify = 'true'
    }
  })
  get_chart_values_to_receive();
  get_chart_values_received();
  
});

function downloadImagesEbook() {
  codeEbook = $("#codeEbookSpan").text();
  $.get({
    //http://[::1]/editorapasteur/publishing/getImages?code=0916900052
    url: "publishing/getImages?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      console.log(data);
      result = JSON.parse(data);
      for (let i = 0; i < result.length; i++) {
        //window.location.href = 'data:application/octet-stream;base64,' + result[i].image+".png";

        var fileDownload = document.createElement("a");
        document.body.appendChild(fileDownload);
        fileDownload.href = "data:image/png;base64, " + result[i].image;
        console.log(fileDownload);
        fileDownload.download = result[i].image_name + ".png";
        fileDownload.click();
        document.body.removeChild(fileDownload);
      }
    },
  });
}

function downloadImagesEbookEditorFinal() {
  codeEbook = $("#codeEbookSpan").text();
  $.get({
    //http://[::1]/editorapasteur/setting/getImages?code=0916900052
    url: "setting/getImages?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      for (let i = 0; i < result.length; i++) {
        //window.location.href = 'data:application/octet-stream;base64,' + result[i].image+".png";
        var fileDownload = document.createElement("a");
        document.body.appendChild(fileDownload);
        fileDownload.href = "data:image/png;base64, " + result[i].image;
        console.log(fileDownload);
        fileDownload.download = "document.png";
        fileDownload.click();
        document.body.removeChild(fileDownload);
      }
    },
  });
}

/*function Export2Doc(element) {
  var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
  var postHtml = "</body></html>";
  var html = preHtml + element + postHtml;

  var blob = new Blob(['\ufeff', html], {
      type: 'application/msword'
  });

  // Specify link url
  var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

  // Specify file name
  filename = 'document.docx';

  // Create download link element
  var downloadLink = document.createElement("a");

  document.body.appendChild(downloadLink);

  if (navigator.msSaveOrOpenBlob) {
      navigator.msSaveOrOpenBlob(blob, filename);
  } else {
      // Create a link to the file
      downloadLink.href = url;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
  }

  document.body.removeChild(downloadLink);
}*/

function getDoc(code) {
  codeEbook = code;
  $.get({
    url: "ebook/getDoc?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);

      result = JSON.parse(data);
      base64 = result[0].content;
      let title = result[0].title;

      const link = document.createElement('a');
      link.href = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,' + base64;
      link.download = title + '.docx';
      link.click();
    }
  });
}



function fillModalEditChapter(codeEbook) {
  $.get({
    url: "setting/getChapter_User?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      $("#codeView").val(result.code); //Código para aparecer na View
      $("#codeEbookHiddenInputText").val(result.code); // Código para enviar com o Modal
      $("#escritorResponsavelEditChapter").val(result.display_name);
      $("#editorResposavelEditChapter").val(result.id_editor);
      $("#editalEditChapter").val(result.id_ebook);
      $("#statusEditChapter").val(result.status);
    },
  });
}

function preencherModalEditEdital(codeEbook) {
  console.log(codeEbook);
  $.get({
    url: "setting/getEdital?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      console.log(data);
      result = JSON.parse(data);
      $("#codeEdital").val(codeEbook)
      $("#codeEditalHidden").val(codeEbook)
      $("#selectEditorEdital").val(result.id_editor)
      $("#nameEdital").val(result.name)
      $("#priceEdital").val(result.price)
      $("#linkEdital").val(result.linkpay)
      $("#descriptionEdital").val(result.description)
      $("#estado").val(result.ativo)

      console.log(data);
    },
  });
}


function preencherModalEditBook(codeEbook) {
  console.log(codeEbook)
  $.get({
    url: "publications/getEbook?id=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      $("#editBookName").val(result.name)
      $("#id").val(codeEbook)
      $("#editParticipants").val(result.participants)
      $("#editISBN").val(result.ISBN)
      $("#editDOI").val(result.doi)
      $("#editKeyWords").val(result.key_words)
      $("#editYear").val(result.year)
      $("#editPresentation").val(result.presentation)
      $("#editState").val(result.ativo)
      //console.log("EditBookModalPreencher=>>",result);
    },
  });
}

function preencherModalEditChapter(codeChapter) {
  console.log(codeChapter)
  $.get({
    url: "publications/getChapter?id=" + codeChapter,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      $('#id').val(codeChapter)
      $('#editName').val(result.name)
      $('#editDOI').val(result.doi)
      $('#authors').val(result.authors)
      $('#editPresentation').val(result.presentation)
      $('#editAtivo').val(result.ativo)
      $('#ebookPertencente').val(result.id_publication)
      $('#editKeyWord').val(result.key_words)
      //console.log("JSON EditChapterModalPreencher=>>",result);
    },
  });
}

function preencherModalVerResumo(titulo) {
  //o frontend já é renderizado com o resumo sendo passado por data-text no <a>
  $("#modalResumoTitle").val(titulo)
  $("#modalResumoContent").text($(event.target).attr("data-text"))
}

function preencherModalChat(code){
  $('#content-message').html('');

  $('#modalChatCode').val(code);
  $.get({
    url: "ebook/get_messages?code=" + code,
    dataType: "text",
    success: function (data) {
      console.log(data);
      result = JSON.parse(data);
      for(let i = 0; i < result.length; i++) {   
        if (result[i].sender == 'editor') {
          $('#content-message').append(`
          <div class="row justify-content-end">
            <span class="col-7">Editor Resonsável&nbsp${result[i].date_sent}</span><br>
            <div class="alert alert-primary col-7">
              ${result[i].message}
            </div>
          </div>`)
        } else{
          $('#content-message').append(`
          <span>${result[i].sender}&nbsp${result[i].date_sent}</span>
          <div class="alert alert-info col-7" role="alert">
            ${result[i].message}
          </div>`)
        }
      }  
    },
  });
}

function preencherModalVerResumoPorCodigo(code) {
  $("#modalResumoTitle").val('')
  $("#modalResumoContent").text('')
  codeEbook = $("#codigoBuscarResumo").val()
  if (!codeEbook) {
    codeEbook = code
  }
  console.log(codeEbook);


  $.get({
    url: "setting/getResumoCodigo?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      console.log(result);
      if (result[0]) {
        resumoObjeto = result[0];
        $("#modalResumoTitle").val(resumoObjeto.title)
        $("#modalResumoContent").text(resumoObjeto.content)
      } else {
        $("#modalResumoTitle").val('')
        $("#modalResumoContent").text("Não foi encontrado o resumo para esse código.")
      }
    }
  })
}

function getDocDownloadFinal(codeHTML) {
  codeEbook = codeHTML;
  $.get({
    url: "setting/getDoc?code=" + codeEbook,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      console.log(result);
      conteudo = "data:application/vnd.ms-word;charset=utf-8," + encodeURIComponent(b64DecodeUnicode(result[0].content));
      var fileDownload = document.createElement("a");
      document.body.appendChild(fileDownload);
      fileDownload.href = conteudo;
      fileDownload.download = `${codeEbook}_Auto_Generated.doc`;
      fileDownload.click();
      document.body.removeChild(fileDownload);

      function b64DecodeUnicode(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function (c) {
          return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
      }

      b64DecodeUnicode('4pyTIMOgIGxhIG1vZGU='); // "✓ à la mode"
      b64DecodeUnicode('Cg=='); // "\n"
    },
  });
}

function downloadEbook(codeE, status) {
  var url;
  var codeEbook;
  try {
    codeEbook = $(event.target)
      .closest("tr")
      .children("td")
      .children("label")
      .children("span.codeEbookSpan")
      .text();
  } catch (e) {
    console.log(e);
    codeEbook = codeE.toString();
  }
  if (codeEbook == "") codeEbook = `${codeE}`;
  if (status == 5) url = "publishing/select?code=";
  else if (status == 1) url = "./select?code=";
  else url = "setting/select?code=";

  $.get({
    url: url + codeE,
    dataType: "text",
    success: function (data) {
      var content;
      result = JSON.parse(data);
      console.log(url)
      console.log(result)

      //var titulo = '<p style="text-align: center;font-family:Times New Roman,Times,serif;font-size: 20pt;color: #120a8f ;line-height: 1,08pt;">A Blue Heading</p>'
      var titulo = result.name;
      titulo = $.parseHTML(titulo);
      $(titulo).attr(
        "style",
        "text-align: center;font-family:Times New Roman, Times, serif;font-size: 20pt;color: #2c71b2;line-height: 1,08pt;"
      );
      content = $("<div />");
      content.append(titulo);
      titulo = $(content).html();

      var author = result.author;
      author = $.parseHTML(author);
      $(author).attr(
        "style",
        "text-align: center;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black;line-height: 1.08pt"
      );
      content = $("<div />");
      content.append(author);
      author = $(content).html();

      var author_affiliations = result.author_affiliations;
      author_affiliations = $.parseHTML(author_affiliations);
      $(author_affiliations).attr(
        "style",
        "text-align: left;font-family:Times New Roman, Times, serif;font-size: 11pt;color: black ;line-height: 1.08pt;"
      );
      content = $("<div />");
      content.append(author_affiliations);
      author_affiliations = $(content).html();

      var introduction = result.introduction;
      introduction = $.parseHTML(introduction);
      console.log(introduction);
      $(introduction).attr(
        "style",
        "text-align: justify;text-indent:1.25cm;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black ;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>INTRODUÇÃO</p>"
      );
      content.append(introduction);
      introduction = $(content).html();

      var method = result.method;
      method = $.parseHTML(method);
      $(method).attr(
        "style",
        "text-align: justify;text-indent:1.25cm;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black ;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>MÉTODO</p>"
      );
      content.append(method);
      method = $(content).html();

      var result_and_discussion = result.result_and_discussion;
      result_and_discussion = $.parseHTML(result_and_discussion);
      $(result_and_discussion).attr(
        "style",
        "text-align: justify;text-indent:1.25cm;font-family: Times New Roman, Times, serif;font-size: 12pt;color: black ;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>RESULTADOS E DISCUSSÃO</p>"
      );
      content.append(result_and_discussion);
      result_and_discussion = $(content).html();

      var conclusion = result.conclusion;
      conclusion = $.parseHTML(conclusion);
      $(conclusion).attr(
        "style",
        "text-align: justify;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>CONCLUSÃO</p>"
      );
      content.append(conclusion);
      conclusion = $(content).html();

      var references = result.book_references;
      console.log(references);
      $(references).attr(
        "style",
        "text-align: justify;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>REFERÊNCIAS</p>"
      );
      content.append(references);
      references = $(content).html();

      var description_case = result.description_case;
      description_case = $.parseHTML(description_case);
      $(description_case).attr(
        "style",
        "text-align: justify;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>DESCRIÇÃO DO CASO</p>"
      );
      content.append(description_case);
      description_case = $(content).html();

      var outcome = result.outcome;
      outcome = $.parseHTML(outcome);
      $(outcome).attr(
        "style",
        "text-align: justify;font-family:Times New Roman, Times, serif;font-size: 12pt;color: black;line-height: 1.5;"
      );
      content = $("<div />");
      content.append(
        "<p style='font-family:Times New Roman, Times, serif;color:orange;font-size:24px'>DESFECHO</p>"
      );
      content.append(outcome);
      outcome = $(content).html();

      // var cidade = "<p>" + result.city + "</p>";
      // var author2 = "<p>" + result.author + "</p>";
      var sourceHTML;
      var header =
        "<html xmlns:o='urn:schemas-microsoft-com:office:office'" +
        "xmlns:w='urn:schemas-microsoft-com:office:word' " +
        "xmlns='http://www.w3.org/TR/REC-html40'>" +
        "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
      var footer = "</body></html>";
      switch (result.type) {
        case "Pesquisa Experimental ou Epidemiológica":
          sourceHTML =
            header +
            titulo +
            author +
            author_affiliations +
            introduction +
            method +
            result_and_discussion +
            conclusion +
            references +
            footer;
          break;
        case "Revisão Bibliográfica":
          sourceHTML =
            header +
            titulo +
            author +
            author_affiliations +
            introduction +
            method +
            result_and_discussion +
            conclusion +
            references +
            footer;
          break;
        case "Relato de Experiência e Estudo de Caso":
          sourceHTML =
            header +
            titulo +
            author +
            author_affiliations +
            introduction +
            description_case +
            outcome +
            conclusion +
            references +
            footer;
          break;
        default:
          console.log("tipo estranho");
      }

      var source =
        "data:application/vnd.ms-word;charset=utf-8," +
        encodeURIComponent(sourceHTML);
      var fileDownload = document.createElement("a");
      document.body.appendChild(fileDownload);
      fileDownload.href = source;
      fileDownload.download = `${codeEbook}_document.doc`;
      fileDownload.click();
      document.body.removeChild(fileDownload);
    },
    error: function (xhr, textStatus, error) {
      console.log(xhr.statusText);
      console.log(textStatus);
      console.log(error);
    },
  });
}

function buscarComprovante() {
  codigoBuscado = $("#codigoPesquisarPagamento").val();
  $("#notFoundMessage").text("Carregando...")
  $.get({
    url: "setting/getComprovanteSearch?code=" + codigoBuscado,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data);
      console.log(result[0].proof_payment);
      if (result[0].proof_payment) {
        img = result[0].proof_payment;
        $("#notFoundMessage").text('')
        $("#imgPagamentoComprovanteModal").attr("src", img)
      } else {
        //$("#imgPagamentoComprovanteModal").attr("src","''")
        $("#notFoundMessage").text("Não foi encontrado comprovante para esse código")
      }
    }
  })

}

function verPagamento() {
  $("#notFoundMessage").text('')
  var currow = $(event.target).closest("td");
  let ImgBase64 = $(currow).children("input.imgPagamentoComprovante").val();
  $("#imgPagamentoComprovanteModal").attr("src", ImgBase64);
}
/////////////////////////////////////////////////////////////////////////////
//Código responsável por preencher as informações no modal de editar usuário/
/////////////////////////////////////////////////////////////////////////////
function fillModalEditUser() {
  var currow = $(event.target).closest("tr");
  idUser = currow[0].id;
  idUserList = $(currow[0]).children(".idUserList").text();
  nomeUserList = $(currow[0]).children(".nomeUserList").text();
  cpfUserList = $(currow[0]).children(".cpfUserList").text();
  emailUserList = $(currow[0]).children(".emailUserList").text();
  telefoneUserList = $(currow[0]).children(".telefoneUserList").text();
  acessoUserList = $(currow[0]).children(".acessoUserList").text();

  $("#idModalEditUser").val(idUserList);
  $("#nomeModalEditUser").val(nomeUserList);
  $("#cpfModalEditUser").val(cpfUserList);
  $("#emailModalEditUser").val(emailUserList);
  $("#telefoneModalEditUser").val(telefoneUserList);
}
/////////////////////////////////////////////////////////////////////////////
//Código responsável preencher o modal de enviar Resumo Ebook////////////////
/////////////////////////////////////////////////////////////////////////////

function fillModalEnvioResumo() {
  var card = $(event.target).closest($(".card"));
  //console.log(card[0]);
  cardBody = $(card[0]).children();
  codeEbook = $(cardBody);
  tipoCapitulo = $(cardBody[1]).text();
  tituloLivro = $(cardBody[2]).text();

  codeEbook = $(cardBody).children("span.codigoEbook").text();
  tipoCapitulo = $(cardBody).children(".tipoEbook").text();

  tituloLivro = $(cardBody).children(".nomeEbook").text();
  console.log($(cardBody).children(".nomeEbook").text());

  console.log("Titulo é: " + tituloLivro);

  //var imgCard = ($(card).children($("div.card-img-top")))
  imgCard = $(card).children().children("a").children("img");

  imagem = $(imgCard[0]).attr("src");
  imgModal = $("#imgEditoraPasteur")[0];

  $(imgModal).attr("src", imagem);
  //$($("#codeEbook")[0]).val(codeEbook);
  $("#codeEbookHiddenInputText").val(codeEbook);
  $("#codeEbookSpan").text(codeEbook);
  $("#tipoCapitulo").val(tipoCapitulo);
  $("#nomeEbook").val(tituloLivro);
}

function fillModalEditResumo(title) {
  var currow = $(event.target).closest($("tr"));
  var tipo = $(event.target).parents("tr");

  imagem = $(currow[0]).children("td").children(".imgNovoEbook").attr("src");
  codigoLivro = $(currow[0])
    .children("td")
    .children("label")
    .children("span.codeEbookSpan")
    .text();
  resumoLabelEscondido = $(currow[0])
    .children("td")
    .children("input.resumoEbookSettings")
    .val();
  autorEmail = $(currow[0])
    .children("td")
    .children("input.autorEmail")
    .val();
  autorName = $(currow[0])
    .children("td")
    .children("input.autorName")
    .val();
  tipoCapitulo = $(currow[0])
    .children()
    .children("span.tipoCapituloEbook")
    .text();
  //console.log(codigoLivro);

  //console.log($(currow[0]).children("td").children("p.conteudoResumoRejeitado").text())
  motivoReprovacao = $(currow[0])
    .children("td")
    .children("p.motivoResumoRejeitado")
    .text();

  imgModal = $("#imgEditoraPasteur")[0];
  $(imgModal).attr("src", imagem);
  $("#tipoCapitulo").val(tipoCapitulo);
  $("#codeEbookSpan").text(codigoLivro);
  $("#codeEbook").val(codigoLivro);

  $("#nomeAutor").empty().append(`${autorName}`)
  $("#emailAutor").empty().append(`${autorEmail}`)

  $("#codeEbookHiddenInputText").val(codigoLivro);
  $("#nomeEbook").val(title);

  $("#textAreaEditResumeSettings").val(resumoLabelEscondido);
  $("#textAreaResumoEbook").val(
    $(currow[0]).children("td").children("p.conteudoResumoRejeitado").text()
  );
  $("#textAreaResumoEbook").text(
    $(currow[0]).children("td").children("p.conteudoResumoRejeitado").text()
  );
  if (motivoReprovacao) {
    $("#divMotivoReprovacao").removeAttr("hidden");
    $("#textAreaMotivoReprovacaoResumo").val(motivoReprovacao);
  } else {
    $("#divMotivoReprovacao").attr("hidden", "true");
  }
}



function fillCodeEbookPayment() {
  var currow = $(event.target).closest($("tr"));
  codigoLivro = $(currow[0])
    .children("td")
    .children("label")
    .children("span.codeEbookSpan")
    .text();
  $("#codeEbookSpanPayment").text(codigoLivro);
  $(codeEbookPayment).val(codigoLivro);
}

function addReference() {
  divReferencias = $(event.target).closest("div").parent().parent();
  tipoReferencia = $("#addReferenceSelectInput").val();
  switch (tipoReferencia) {
    case "1":
      $(divReferencias).append(
        `
              <div>
              <div style="margin-top:7px;" class="row col-12">
                <hr style="width:100%;">
                <h3>Referencia de Livro</h3>
                <hr style="width:100%;">
                <div class="row col-6">
                    <label for=""><b >Nome do Livro</b> <span class="text-danger">*</span></label>    
                    <input type="text" name="" class="form-control nomeLivro">
                </div>
                <div class="row col-6">
                    <label style="margin-top:5px;" for=""><b >Cidade</b> <span class="text-danger">*</span></label>    
                    <input type="text" name="" class="form-control cidade">
                </div>
                <div class="row col-6">
                    <label for=""><b >Ano</b> <span class="text-danger">*</span></label>    
                    <input type="text" name="" class="form-control ano">
                </div>
                <div class="row col-6">
                    <label for=""><b >Editora</b> <span class="text-danger">*</span></label>    
                    <input type="text" name="cidade" class="form-control editora">
                </div>
                <div class="row col-12 autorDiv">
                        <div class="col-9">
                            <label for=""><b >Autor</b> <span class="text-danger autorDiv">*</span></label>    
                            <input id="referenciaAutor"type="text" placeholder="Nome Sobrenome" class="form-control autorInput">
                        </div>
                        <div class="col-3">
                            <div class="btn btn-dark" onclick="addAutorReferencia()"style="margin-top:25px;">+</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div onclick="formatarReferenciaLivro()" class="btn btn-success" style="margin-top:30px;">Formatar</div>
                    </div>
                    <div class="col-3">
                        <div onclick="removerReferenciasLivro()" class="btn btn-danger" style="margin-top:30px;">Remover</div>
                    </div>
                </div>
              
                <div style="margin-top:20px;" class="col-12">
                    <h6 >Como será enviado:</h6>
                    <input name="referencia_Formatada[]" class="form-control resultCapituloReferencia"></h3>
                </div>
                <hr style="width:100%;">
            </div>
          </div>`
      );
      break;
    case "2":
      $(divReferencias).append(`
          <div style="margin-top:7px;" class="row col-12">
              <hr style="width:100%;">
                  <h3>Referencia de Capítulo de Livro</h3>
                  <hr style="width:100%;">
                  <div class="row col-6">
                      <label for=""><b >Nome do autor do capítulo</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control nomeAutorCapitulo">
                  </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b >Nome do capítulo</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control nomeCapitulo">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Nome do autor do lívro</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control nomeAutorLivro">
                  </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b >Nome do livro</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control nomeLivro">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Cidade</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="cidade" class="form-control cidade">
                  </div>
                  <div class="row col-6">
                      <label for="" ><b >Editora</b> <span class="text-danger ">*</span></label>    
                      <input type="text" name="editora" class="form-control editora">
                  </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b>Ano</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control ano">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Páginas</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="editora" class="form-control paginas">
                  </div>
                  <div class="col-3">
                      <div onclick="formatarReferenciaCapitulo()" class="btn btn-success" style="margin-top:30px;">Formatar</div>
                  </div>
                  <div class="col-3">
                      <div onclick="removerReferenciasCapitulo()" class="btn btn-danger" style="margin-top:30px;">Remover</div>
                  </div>
                  <div style="margin-top:20px;" class="col-12">
                    <h6 >Como será enviado:</h6>
                    <input name="referencia_Formatada[]" class="form-control resultCapituloReferencia"></h3>
                  </div>
                  <hr style="width:100%;" hidden>
              </div>`);
      break;
    case "3":
      $(divReferencias).append(`
        <div class="row">
          <div style="margin-top:7px;" class="row col-12">
              <hr style="width:100%;">
                  <h3>Referencia de Artigo</h3>
                  <hr style="width:100%;">
                  <div class="row col-6 autorDiv">
                    <div class="col-9">
                        <label for=""><b >Autor</b> <span class="text-danger ">*</span></label>    
                        <input id="referenciaAutor"type="text" placeholder="Nome Sobrenome" class="form-control autorInput">
                    </div>
                    <div class="col-3">
                        <div class="btn btn-dark" onclick="addAutorReferencia()"style="margin-top:25px;">+</div>
                    </div>
                  </div>
                </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b >Título do Trabalho</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control tituloTrabalho">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Nome da Revista ou Jornal</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control nomeRevistaJornal">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Cidade</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="cidade" class="form-control cidade">
                  </div>
                  <div class="row col-6">
                      <label for="" ><b >Volume</b> <span class="text-danger ">*</span></label>    
                      <input type="text" name="editora" class="form-control volume">
                  </div>
                  <div class="row col-6">
                      <label for="" ><b >Número</b> <span class="text-danger ">*</span></label>    
                      <input type="text" name="editora" class="form-control numero">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Páginas</b> <span class="text-danger">*</span></label>    
                      <input placeholder="12-18"type="text" name="editora" class="form-control paginas">
                  </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b>Mês (0 a 12)</b> <span class="text-danger">*</span></label>    
                      <input type="number" name="" class="form-control mes">
                  </div>
                  <div class="row col-6">
                      <label style="margin-top:5px;" for=""><b>Ano</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control ano">
                  </div>
                  <div class="col-3">
                      <div onclick="formatarReferenciaArtigos()" class="btn btn-success" style="margin-top:30px;">Formatar</div>
                  </div>
                  <div class="col-3">
                      <div onclick="removerReferenciasArtigo()" class="btn btn-danger" style="margin-top:30px;">Remover</div>
                  </div>
                  <div style="margin-top:20px;" class="col-12">
                    <h6 >Como será enviado:</h6>
                    <input name="referencia_Formatada[]" class="form-control resultCapituloReferencia"></h3>
                  </div>
                  <hr style="width:100%;" hidden>
              </div>
            </div>`);
      break;
    case "4":
      $(divReferencias).append(`
          <div style="margin-top:7px;" class="row col-12">
              <hr style="width:100%;">
                  <h3>Referencia de Site</h3>
                  <hr style="width:100%;">
                  <div class="row col-6">
                      <label for=""><b >Autoria</b> <span class="text-danger">*</span></label>    
                      <input type="text" placeholder="Órgão, empresa ou autor pessoa física" class="form-control dominio">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Link</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="" class="form-control linkReferencia">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Dia do acesso</b> <span class="text-danger">*</span></label>    
                      <input type="number" name="cidade" class="form-control diaAcesso">
                  </div>
                  <div class="row col-6">
                      <label for=""><b >Mes do acesso (Por extenso)</b> <span class="text-danger">*</span></label>    
                      <input type="text" name="editora" class="form-control mesAcesso">
                  </div>
                  <div class="row col-6">
                      <label for="" ><b >Ano acesso</b> <span class="text-danger ">*</span></label>    
                      <input type="number" name="editora" class="form-control anoAcesso">
                  </div>
                  <div class="col-3">
                      <div onclick="formatarReferenciaSites()" class="btn btn-success" style="margin-top:30px;">Formatar</div>
                  </div>
                  <div class="col-3">
                      <div onclick="removerReferenciasCapitulo()" class="btn btn-danger" style="margin-top:30px;">Remover</div>
                  </div>
                  <div style="margin-top:20px;" class="col-12">
                    <h6 >Como será enviado:</h6>
                    <input name="referencia_Formatada[]" class="form-control resultCapituloReferencia"></h3>
                  </div>
                  <hr style="width:100%;" hidden>
              </div>`);
      break;
    case "5":
      $(divReferencias).append(`
          <div style="margin-top:7px;" class="row col-12">
          <hr style="width:100%;">
              <h3>Referencia de Documento Jurídico</h3>
              <hr style="width:100%;">
              <div class="row col-6">
                  <label for=""><b >Órgão Superior (país)</b> <span class="text-danger">*</span></label>    
                  <input type="text" name="" class="form-control orgaoSuperior">
              </div>
              <div class="row col-6">
                  <label style="margin-top:5px;" for=""><b >Ministério ou setor responsável</b> <span class="text-danger">*</span></label>    
                  <input type="text" name="" class="form-control ministerioOuSetor">
              </div>
              <div class="row col-6">
                  <label for=""><b >Título</b> <span class="text-danger">*</span></label>    
                  <input type="text" name="" class="form-control titulo">
              </div>
              <div class="row col-6">
                  <label for=""><b >Cidade</b> <span class="text-danger">*</span></label>    
                  <input type="text" name="cidade" class="form-control cidade">
              </div>
              <div class="row col-6">
                  <label for=""><b >Ano</b> <span class="text-danger">*</span></label>    
                  <input type="number" name="editora" class="form-control ano">
              </div>
              <div class="col-3">
                  <div onclick="formatarReferenciaLegislacao()" class="btn btn-success" style="margin-top:30px;">Formatar</div>
              </div>
              <div class="col-3">
                  <div onclick="removerReferenciasCapitulo()" class="btn btn-danger" style="margin-top:30px;">Remover</div>
              </div>
              <div style="margin-top:20px;" class="col-12">
                    <h6 >Como será enviado:</h6>
                <input name="referencia_Formatada[]" class="form-control resultCapituloReferencia"></h3>
              </div>
              <hr style="width:100%;" hidden>
          </div>`);
      break;
  }
};
function formatarReferenciaLivro() {
  var divReferencia = $(event.target).parent().parent().parent();

  var nomeLivro = $(divReferencia)
    .children()
    .children()
    .children("input.nomeLivro")
    .val();
  var cidade = $(divReferencia)
    .children()
    .children()
    .children("input.cidade")
    .val();
  var ano = $(divReferencia).children().children().children("input.ano").val();
  var editora = $(divReferencia)
    .children()
    .children()
    .children("input.editora")
    .val();
  //var autorInput = $(divReferencia).children().children().children("input.autorInput").val()
  autordivs = $(divReferencia).children().children("div.autorDiv");

  //var nomeLivro = $(divReferencia).children().children("input.nomeLivro").val()
  //var divReferencia = $(event.target).parent().parent().parent()//Pega a div toda da referência
  //autor = $(divReferencia).children().children().children().children("input.autorInput").val() //Pega todos os inputs de autor
  //console.log(autordiv.length);

  let autoresSeparados = null;
  if (autordivs.length < 4) {
    for (let i = 0; i < autordivs.length; i++) {
      autor = $(autordivs[i]).children().children("input.autorInput").val();
      var n = autor.split(" ");
      ultimoNome = n[n.length - 1]; //Pega o ultimo nome
      ultimoNome = ultimoNome.replace(/\s?$/, ""); //remove o espaço no final do nome
      novoNome = autor.replace(ultimoNome, "").replace(/\s?$/, ""); //tira o último nome do nome
      autorFormatado = ultimoNome.toUpperCase();
      autorFinal = autorFormatado + ", " + novoNome;
      if (autoresSeparados) {
        autoresSeparados = autoresSeparados + "; " + autorFinal;
      } else {
        autoresSeparados = autorFinal;
      }
      multiplosEditoresFinalizados = autoresSeparados + ". ";
    }
  } else {
    autor = $(autordivs[0]).children().children("input.autorInput").val();
    var n = autor.split(" ");
    ultimoNome = n[n.length - 1]; //Pega o ultimo nome
    ultimoNome = ultimoNome.replace(/\s?$/, ""); //remove o espaço no final do nome
    novoNome = autor.replace(ultimoNome, "").replace(/\s?$/, ""); //tira o último nome do nome
    autorFormatado = ultimoNome.toUpperCase();
    autorFinal = autorFormatado + ", " + novoNome;
    multiplosEditoresFinalizados = autorFinal + " et al. "
  }

  nomeLivro =
    nomeLivro.toLowerCase() &&
    nomeLivro[0].toUpperCase() + nomeLivro.slice(1) + ". ";

  cidade = cidade
    .toLowerCase()
    .split(" ")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
  cidade_editora = cidade + ":" + editora;

  stringFinal = multiplosEditoresFinalizados + nomeLivro + cidade_editora + ", " + ano;
  //console.log(stringFinal);
  var input = $(divReferencia)
    .children()
    .children("input.resultCapituloReferencia");
  $(input).val(stringFinal);
};

function formatarReferenciaCapitulo() {
  var divReferencia = $(event.target).parent().parent();
  var nomeAutorCapitulo = $(divReferencia)
    .children()
    .children("input.nomeAutorCapitulo")
    .val();
  var nomeCapitulo = $(divReferencia)
    .children()
    .children("input.nomeCapitulo")
    .val();
  var nomeAutorLivro = $(divReferencia)
    .children()
    .children("input.nomeAutorLivro")
    .val();
  var nomeLivro = $(divReferencia).children().children("input.nomeLivro").val();
  var cidade = $(divReferencia).children().children("input.cidade").val();
  var editora = $(divReferencia).children().children("input.editora").val();
  var ano = $(divReferencia).children().children("input.ano").val();
  var paginas = $(divReferencia).children().children("input.paginas").val();

  var n = nomeAutorCapitulo.split(" ");
  ultimoNome = n[n.length - 1]; //Pega o ultimo nome
  ultimoNome = ultimoNome.replace(/\s?$/, ""); //remove o espaço no final do nome
  novoNome = nomeAutorCapitulo.replace(ultimoNome, "").replace(/\s?$/, ""); //tira o último nome do nome
  autorFormatado = ultimoNome.toUpperCase();
  autorFinal = autorFormatado + ", " + novoNome;

  nomeCapitulo = nomeCapitulo.toLowerCase();
  nomeCapitulo =
    nomeCapitulo && nomeCapitulo[0].toUpperCase() + nomeCapitulo.slice(1);

  nomeAutorLivro = nomeAutorLivro.toLowerCase();
  nomeAutorLivro =
    nomeAutorLivro && nomeAutorLivro[0].toUpperCase() + nomeAutorLivro.slice(1);

  nomeLivro = nomeLivro.toLowerCase();
  nomeLivro = nomeLivro && nomeLivro[0].toUpperCase() + nomeLivro.slice(1);

  formatacaoFinal =
    autorFinal +
    ". " +
    nomeCapitulo +
    ". ln: " +
    nomeAutorLivro +
    ". " +
    nomeLivro +
    ". " +
    cidade +
    ": " +
    editora +
    ", " +
    ano +
    ". p. " +
    paginas;
  //console.log(formatacaoFinal);

  var input = $(divReferencia)
    .children()
    .children("input.resultCapituloReferencia");
  $(input).val(formatacaoFinal);
};

function formatarReferenciaArtigos() {

  var divReferencia = $(event.target).parent().parent();
  autordivs = $(divReferencia).children().children("div.autorDiv");
  let autoresSeparados = null;
  if (autordivs.length < 4) {
    for (let i = 0; i < autordivs.length; i++) {
      autor = $(autordivs[i]).children().children("input.autorInput").val();
      var n = autor.split(" ");
      ultimoNome = n[n.length - 1]; //Pega o ultimo nome
      ultimoNome = ultimoNome.replace(/\s?$/, ""); //remove o espaço no final do nome
      novoNome = autor.replace(ultimoNome, "").replace(/\s?$/, ""); //tira o último nome do nome
      autorFormatado = ultimoNome.toUpperCase();
      autorFinal = autorFormatado + ", " + novoNome;
      console.log(autorFinal);
      if (autoresSeparados) {
        autoresSeparados = autoresSeparados + "; " + autorFinal;
      } else {
        autoresSeparados = autorFinal;
      }
      nomeAutorCapitulo = autoresSeparados;
    }
  } else {
    autor = $(autordivs[0]).children().children("input.autorInput").val();
    var n = autor.split(" ");
    ultimoNome = n[n.length - 1]; //Pega o ultimo nome
    ultimoNome = ultimoNome.replace(/\s?$/, ""); //remove o espaço no final do nome
    novoNome = autor.replace(ultimoNome, "").replace(/\s?$/, ""); //tira o último nome do nome
    autorFormatado = ultimoNome.toUpperCase();
    autorFinal = autorFormatado + ", " + novoNome;
    nomeAutorCapitulo = autorFinal + " et al"
  }

  var tituloTrabalho = $(divReferencia)
    .children()
    .children("input.tituloTrabalho")
    .val();
  var nomeRevistaJornal = $(divReferencia)
    .children()
    .children("input.nomeRevistaJornal")
    .val();
  var cidade = $(divReferencia).children().children("input.cidade").val();
  var volume = $(divReferencia).children().children("input.volume").val();
  var numero = $(divReferencia).children().children("input.numero").val();
  var ano = $(divReferencia).children().children("input.ano").val();
  var paginas = $(divReferencia).children().children("input.paginas").val();
  var mes = $(divReferencia).children().children("input.mes").val();

  function LetterCapitalize(str) {
    return str
      .split(" ")
      .map((item) => item.substring(0, 1).toUpperCase() + item.substring(1))
      .join(" ");
  }
  nomeRevistaJormalFormatado = LetterCapitalize(nomeRevistaJornal);

  tituloTrabalho = tituloTrabalho.toLowerCase();
  tituloTrabalho =
    tituloTrabalho && tituloTrabalho[0].toUpperCase() + tituloTrabalho.slice(1);

  meses = [
    "",
    "jan",
    "fev",
    "mar",
    "abr",
    "mai",
    "jun",
    "jul",
    "ago",
    "set",
    "out",
    "nov",
    "dez",
  ];

  let formatacaoFinal =
    nomeAutorCapitulo +
    ". " +
    tituloTrabalho +
    ". " +
    nomeRevistaJormalFormatado +
    ", " +
    cidade +
    ", v. " +
    volume +
    ", n. " +
    numero +
    ", p. " +
    paginas +
    ", " +
    meses[mes] +
    ". " +
    ano;

  var input = $(divReferencia)
    .children()
    .children("input.resultCapituloReferencia");
  $(input).val(formatacaoFinal);
};
function formatarReferenciaSites() {
  var divReferencia = $(event.target).parent().parent();
  var dominio = $(divReferencia).children().children("input.dominio").val();
  var linkReferencia = $(divReferencia)
    .children()
    .children("input.linkReferencia")
    .val();
  var diaAcesso = $(divReferencia).children().children("input.diaAcesso").val();
  var mesAcesso = $(divReferencia).children().children("input.mesAcesso").val();
  var anoAcesso = $(divReferencia).children().children("input.anoAcesso").val();

  function LetterCapitalize(str) {
    return str
      .split(" ")
      .map((item) => item.substring(0, 1).toUpperCase() + item.substring(1))
      .join(" ");
  }
  function primeiraLetraMaiuscula(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  dominioUpperCase = dominio.toUpperCase();

  let formatacaoFinal =
    dominioUpperCase +
    ". Disponível em: " +
    linkReferencia +
    ". Acesso em: " +
    diaAcesso +
    " de " +
    mesAcesso +
    " de " +
    anoAcesso +
    ".";

  var input = $(divReferencia)
    .children()
    .children("input.resultCapituloReferencia");
  $(input).val(formatacaoFinal);
};

function formatarReferenciaLegislacao() {
  var divReferencia = $(event.target).parent().parent();
  var orgaoSuperior = $(divReferencia)
    .children()
    .children("input.orgaoSuperior")
    .val();
  var ministerioOuSetor = $(divReferencia)
    .children()
    .children("input.ministerioOuSetor")
    .val();
  var titulo = $(divReferencia).children().children("input.titulo").val();
  var cidade = $(divReferencia).children().children("input.cidade").val();
  var ano = $(divReferencia).children().children("input.ano").val();

  function primeiraLetraMaiuscula(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  orgaoFormatado = orgaoSuperior.toUpperCase();
  ministerioFormatado = primeiraLetraMaiuscula(ministerioOuSetor);
  tituloFormatado = primeiraLetraMaiuscula(titulo);
  cidade = primeiraLetraMaiuscula(cidade);

  let formatacaoFinal =
    orgaoFormatado +
    ". " +
    ministerioFormatado +
    ". " +
    tituloFormatado +
    ". " +
    cidade +
    ", " +
    ano +
    ".";

  var input = $(divReferencia)
    .children()
    .children("input.resultCapituloReferencia");
  $(input).val(formatacaoFinal);
};

function addAutorReferencia() {
  inputAutor = `
      <div class="row col-6 autorDiv">
          <div class="col-10 no-padding-left">
              <label for=""><b >Autor</b> <span class="text-danger ">*</span></label>    
              <input type="text" name="" placeholder="Nome Sobrenome" class="form-control autorInput">
          </div>
          <div class="col-2">
              <div class="btn btn-danger" onclick="removerAutorReferencia()"style="margin-top:25px;">x</div>
          </div>
      </div>
      `;
  var divAutor = $(event.target).parent().parent().parent();
  divAutor.append(inputAutor);
};

function removerAutorReferencia() {
  var divAutor = $(event.target).parent().parent();
  console.log($(divAutor));
  $(divAutor).html("");
};

function removerReferenciasLivro() {
  divReferencias = $(event.target).closest("div").parent().parent().parent();
  $(divReferencias).html("");
};
function removerReferenciasCapitulo() {
  divReferencias = $(event.target).closest("div").parent().parent();
  $(divReferencias).html("");
};
function removerReferenciasArtigo() {
  divReferencias = $(event.target).closest("div").parent().parent();
  $(divReferencias).html("");
};
function addImagesInput() {
  var divImage = $(event.target)
    .parent()
    .parent()
    .append(
      '<div class="row" style="margin-bottom:7px;margin-left:5px;"><input class="form-control col-10" type="file" name="photos[]"/><div onclick="removeImagesInput()" style="margin-left:5px;" class="btn btn-dark col-1">-</div></div>'
    );
};
function removeImagesInput() {
  var divImage = $(event.target).parent().html("");
};

function downloadCertified(code) {
  console.log(code);

  meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]

  $.get({
    url: "ebook/select_certified?code=" + code,
    dataType: "text",
    success: function (data) {

      result = JSON.parse(data);

      if (result.date_emission) {
        mesEmissao = meses[new Date(result.date_emission + ' ').getMonth()];
        anoEmissao = new Date(result.date_emission + ' ').getFullYear();

        abrediv = `<div style = "text-align: left; padding: 15%; background-image: url('assets/images/capa.png'); height:1918px; width:1357px" >`;

        prezadosAutores = `<h4 style="color:#002E5D; margin-top:30%; font-size:27px"> Prezados autores, </h4> <br>`;

        paragrafo = '<p align="justify" style="margin: 5%; font-size: 27px;" ><b> ' + result.author + ',</b> este documento atesta que o capítulo <b>' + result.name_chapter + '</b> foi aceito para compor o livro ' +
          result.name + ' e, que o mesmo será publicado em ' + mesEmissao + ' de ' + anoEmissao + ' pela Editora Pasteur, Irati/PR, prefixo editorial 86700. </p>';

        paragrafoInferior = '<p align="justify" style="margin: 5%; font-size: 27px;"> O livro atende a todos os requisitos solicitados pela CAPES, e.g. corpo editorial, ISBN, índice remissivo e avaliação por pares.</p>';

        imageAssinatura = `
        <div style="background-image: url('assets/images/assinatura.png'); height: 200px; width: 700px; margin-left:15%"></div>

        <p align="justify" style="margin-left: 20%; text-align: center; font-weight:700; font-size: 17px; width: 700px;"> 
          Dr. Guilherme Barroso L. de Freitas <br>

          Diretor Científico do Instituto de Ensino Pasteur <br>
          Editor Chefe da Editora Pasteur
        </p>`;

        agradeço = '<p align="justify" style="margin: 5%; font-size: 27px;">Agradeço suas contribuições para produção deste livro. </p>';

        certificado = '<br> <br> <p align="justify" style="margin: 5%;  font-size: 22px;">Para validar o certificado, acesse https://editorapasteur.com.br/sistema/public/certification e insira o código: ' + result.code + ' </p>';

        fechaDiv = '</div>'

        html2pdf().from(
          abrediv + prezadosAutores + paragrafo + paragrafoInferior + agradeço + imageAssinatura + certificado + fechaDiv
        ).set({
          html2canvas: {
            width: 1357,
            height: 1918
          }
        }).save();
      }
      else {
        alert("A geração de certificados automatizada não está disponível para este capítulo. Por favor, entre em contato com o nosso atendimento.")
      }
    }
  });
}

function validarCertificado() {
  $.get({
    url: "certification/autenticate?code=" + $('#codeCertification').val() + "&date=" + $('#date_emission').val(),
    dataType: "text",
    success: function (data) {
      if (data) {
        result = JSON.parse(data);
        $("#alerta-result").attr("hidden", false);
        $("#alerta-result").html("Atestamos que o certificado de submissão do capítulo é válido e foi submetido para o livro <b>" + result.name + "</b>");
        $("#alerta-result").attr("class", 'alert alert-success');
      } else {
        $("#alerta-result").attr("hidden", false);
        $("#alerta-result").html("Atestamos que não há registros para as informações inseridas. Para mais informações entre em contato com o nosso atendimento.");
        $("#alerta-result").attr("class", 'alert alert-danger');
      }
    }

  }
  )
}

function validarCertificadoDOI() {
  $.get({
    url: "certification/autenticate?code=" + $('#doiCertification').val() + "&type=doi",
    dataType: "text",
    success: function (data) {
      if (data) {
        result = JSON.parse(data);
        console.log(result);
        $("#alerta-result").attr("hidden", false);
        $("#alerta-result").html("Atestamos que o certificado do capítulo <b>" + result.chapter + "</b> é válido e foi publicado no livro <b>" + result.ebook + "</b>");
        $("#alerta-result").attr("class", 'alert alert-success');
      } else {
        $("#alerta-result").attr("hidden", false);
        $("#alerta-result").text("Atestamos que o capítulo com o DOI informado é inválido. Para mais informações entre em contato com o nosso atendimento.");
        $("#alerta-result").attr("class", 'alert alert-danger');
      }
    }

  }
  )
}

function preencheModalAutores(code) {
  $('#modalAutoresCode').val(code)
}


function fillModalSendComprovation(code) {
  $('#codeEbookPayment').val(code);
}

function preencherModalVoltarCapitulo(code){
  $('#codeEbookVoltar').val(code);
}

function preencherModalAprovarCapitulo(code){
  $('#codeEbookAprovar').val(code);
}

function preencherModalHistorico(code){
  $('#content-text').html('');
  console.log(code);
  $('#codeChapterHistorico').val(code);
  $.get({
    url: "publishing/get_historic?code=" + code,
    dataType: "text",
    success: function (data) {
      console.log(data);
      result = JSON.parse(data);
      for(let i = 0; i < result.length; i++) {
          $('#content-text').append(`
          <div class="row justify-content-end">
            <span class="col-12">Data/Hora &nbsp${result[i].date || 'Sem registro'}</span><br>
            <div class="alert alert-primary col-12">
              ${result[i].text}
            </div>
          </div>`)
      }  
    },
  });
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function read(input) {
  const reader = new FileReader();
  const csv = input.files[0];
  reader.readAsText(csv);
  reader.onload = function (e) {
    formatarCSV(e.target.result)
  }
}


function cleanValue(event){
  $(event.target).text('');
}

categoriaAtual = ''
function formatarCSV(csv) {
  let lines = csv.split("\n");
  //console.log(lines);
  tableBody = $('#import_table_products').html('');
  
  for (let i = 1; i < lines.length; i++) {
    //Aqui retira o ponto e vírgula entre as colunas e colunas vazias
    //let currentline = lines[i].split(";").filter(Boolean);
    //let nextLine = lines[i+1].split(";").filter(Boolean);
    
    let currentline = lines[i].split(";");
    let nextLine = lines[i+1].split(";");
    
    if(nextLine[3] == '' && nextLine[4] != ''){
      currentline[4] += nextLine[4];
    }

    if(currentline[2] != ''){
      categoriaAtual = currentline[2].replace(/:/g, " > ");
    }
    currentline[10] = categoriaAtual;

    if(currentline[3] != ''){
      tableData =
      `<tr>
      <td></td>
      <td><input type="checkbox"></td>
      <td>${currentline[3]}</td>
      <td contenteditable="true">${currentline[4]}</td>
      <td contenteditable="true">${currentline[6]}</td>
      <td>${currentline[5]}</td>
      <td contenteditable="true" onblur="calculate_values(event)" onfocus="cleanValue(event)"> ${currentline[10]} </td>
      </tr>`
      tableBody.append(tableData);
    }
    //console.log(currentline);
    //console.log(nextLine[3]);

    //console.log(currentline);
    // Esses Ifs
    // - tiram as linhas que começam com 'Resumo de':
    // - Adicionam estoque 1 para produtos sem estoque
    // - Adicionam estoque 1 para produtos com estoque 0
    
    /*if (currentline.length > 6 && currentline[0] != 'Resumo de:' && currentline[0] != 'Identifica��o') {
      if (currentline.length == 7){
        currentline.splice(5, 0, '1');
      }
      if (currentline[6] == 0){
        currentline[6] = '1';
      }

      tableData =
      `<tr>
      <td></td>
      <td><input type="checkbox"></td>
      <td>${currentline[0]}</td>
      <td contenteditable="true">${currentline[1]}</td>
      <td contenteditable="true">${currentline[5]}</td>
      <td>${currentline[4]}</td>
      <td contenteditable="true" onblur="calculate_values(event)" onfocus="cleanValue(event)"> - </td>
      <td>30%</td>
      <td>${(Number(currentline[4].replace(/[R\$ \.]/g, '').replace(',', '.')) * 1.3).toFixed(2)}</td>
      </tr>`
      tableBody.append(tableData);
    }*/   
  }
}

function calculate_values(event){
  preco = $(event.target).parent().find("td:eq(5)").text();
  webValue = $(event.target).text();

  precoNumber = (Number(preco.replace(',', '.')));

  target = webValue * 0.9;

  diferenca = (precoNumber*1.17) - target

  marcapFinal = -1 * (Math.round((diferenca / precoNumber) * 100))

  checkbox = $($(event.target).parent().find("td:eq(1)").children())

  color = 'black'
  if (marcapFinal > 31 ){
    color = 'green';
    checkbox.attr("checked", true)
  }
  if (marcapFinal < 29 ){
    color = 'orange';
    checkbox.attr("checked", false)
    if (marcapFinal < 0){
      color = 'red';
    }
  }

  if (!isNaN(parseInt(marcapFinal))){
    $(event.target).parent().find("td:eq(7)").css('color', color);
    $(event.target).parent().find("td:eq(7)").text(marcapFinal + '%');
    $(event.target).parent().find("td:eq(8)").text(target.toFixed(2));
  }else{
    $(event.target).parent().find("td:eq(7)").css('color', 'red');
    $(event.target).parent().find("td:eq(8)").css('color', 'red');
  }
}

function saveTable(){
  tableData = $("#import_table_products").html();  
  $.post("setting/save_table",
  {tableData: tableData}, 
  function(result){
    if(result){
      document.location.reload(true);
    }else{
      alert("Houve algum problema.");
    }
  })
}

function select_table_state(event){
  $.get({
    url: "setting/select_table_state?date=" + event.target.value,
    dataType: "text",
    success: function (data) {
      $("#import_table_products").html(data)
    }
  })
}

function exportToExcel(){
  table = $("#import_table_products");
  result = [];
  for(i = 0;i < $(table).children().length; i++){
    result.push(table.children()[i]);
  }

  tbody_result = '<tbody>'
  for (i=0; i< result.length;i++){
    tbody_result += '<tr>'
    tbody_result += $(result[i]).html();
    tbody_result += '</tr>'
  }
  tbody_result += '</tbody>'

  var htmls = "";
  var uri = 'data:application/vnd.ms-excel;base64,';
  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
  var base64 = function(s) {
      return window.btoa(unescape(encodeURIComponent(s)))
  };

  var format = function(s, c) {
      return s.replace(/{(\w+)}/g, function(m, p) {
          return c[p];
      })
  };
  htmls = tbody_result;

  var ctx = {
      worksheet : 'Worksheet',
      table : htmls
  }

  var link = document.createElement("a");
  link.download = "export_bling.xls";
  link.href = uri + base64(format(template, ctx));
  link.click(); 
}

function readXML(input) {
  const reader = new FileReader();
  const xml = input.files[0];
  reader.readAsText(xml);
  reader.onload = function (e) {
    preencherModalXML(e.target.result);
  }
}

function preencherModalXML(xml_row){
  xmlDoc = $.parseXML(xml_row);
  xml = $(xmlDoc);
  numero = xml.find("nNF").text();
  emissor = xml.find("emit").find("xNome").text();
  destino = xml.find("dest").find("xNome").text();
  //liquido = xml.find("fat").find("vLiq").text();
  formaPagamento = xml.find("tPag").text();
  observacao = xml.find("infAdic").text();
  pagamentos = xml.find("dup");
  //valores=[];
  //datasVencimento=[];
  $('#payment_div').html('');
  for(let i = 0; i< pagamentos.length; i++){
    $('#payment_div').append(`
    <div class="row col-12">
    <input type="text" name="parcel_value[]" class="form-control col-5" value="${$(pagamentos[i]).find("vDup").text()}" readonly>
    <input type="text" name="parcel_date[]" class="form-control col-5" value="${$(pagamentos[i]).find("dVenc").text()}" readonly> </div><br>
    `)
    //valores[i] = $(pagamentos[i]).find("vDup").text();
    //datasVencimento[i] = $(pagamentos[i]).find("dVenc").text();
  }

  $.get({
    url: "setting/xml_exists?number=" + numero,
    dataType: "text",
    success: function (data) {
      if (data == 200){
        alert("Esse xml já está cadastrado, tente novamente com um novo.");
      }
    }
  })

  $("#number").val(numero)
  $("#emiter").val(emissor)
  $("#destine").val(destino)
  $("#payment_method").val(formaPagamento)
  $("#observation").val(observacao)
}

function select_date_xml(event){
  var href = new URL(window.location.href);
  href.searchParams.set('year_mouth', event.target.value);
  window.location.replace(href.toString());
}

function select_income_xml(event){
  var href = new URL(window.location.href);
  href.searchParams.set('income', event.target.value);
  window.location.replace(href.toString());
}

function select_client_filter(event){
  var href = new URL(window.location.href);
  href.searchParams.set('client', event.target.value);
  window.location.replace(href.toString());
}

function select_account_filter(event){
  var href = new URL(window.location.href);
  href.searchParams.set('account', event.target.value);
  window.location.replace(href.toString());
}

function select_account_filter(event){
  var href = new URL(window.location.href);
  href.searchParams.set('account', event.target.value);
  window.location.replace(href.toString());
}

function select_status_filter(event){
  var href = new URL(window.location.href);
  href.searchParams.set('status', $(event.target).val());
  window.location.replace(href.toString());
}

function read_file_RET(input){
  const reader = new FileReader();
  const ret = input.files[0];
  reader.readAsText(ret);
  reader.onload = function (e) {
    preencherModalRET(e.target.result);
  }
}

function select_date_payments(event){
  if(($("#date_init").val() != '') && ($("#date_end").val() != '')){
    console.log($(event.target).attr('id'))
    var href = new URL(window.location.href);
    href.searchParams.set('date_init', $("#date_init").val());
    href.searchParams.set('date_end', $("#date_end").val());
    window.location.replace(href.toString());
  }
}

var moneyFormatter = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'USD',
  minimumFractionDigits: 2
});

function preencherModalRET(ret){

  $("#payment_list").html('');
  result = ret.split('\r');
  result.shift();
  result.pop();
  result.pop();
  objArray = [];
  count_entryes = 0;

  for (i=0; i< result.length; i++){
    valorFloat = parseFloat(result[i].substr(254,13));
    valorString = String(valorFloat);

    data = result[i].substr(147,6);


    ano = '20'+data.substr(4,2);
    mes = data.substr(2,2);
    dia = data.substr(0,2);
    
  
    dataPagamento = result[i].substr(296,6);
    anoPagamento = '20'+dataPagamento.substr(4,2);
    mesPagamento = dataPagamento.substr(2,2);
    diaPagamento = dataPagamento.substr(0,2);
    data_pagamento = `${anoPagamento}-${mesPagamento}-${diaPagamento}`;

    //result[i].substring(0,result[i].length-2)+"."+result[i].substring(result[i].length-2)

    lista_pagamentos = {
      codigo: parseInt((result[i].substr(119,8))),
      valor: valorString.substring(0,valorString.length-2)+"."+valorString.substring(valorString.length-2),
      data: `${ano}-${mes}-${dia}`,
      data_pagamento: data_pagamento,
      notApproved: result[i].substr(175,12),
      isLiquidation : result[i].substr(109,2)
    }

    console.log(lista_pagamentos.isLiquidation);
    
    //Essa linha confere se a entrada realmente é de um pagamento aprovado
    if(lista_pagamentos.notApproved == 2 || lista_pagamentos.isLiquidation != 06){
      $("#payment_list").append(`<p> O registro ${lista_pagamentos.codigo} não consta como liquidação e não será aprovado.</p>`)
      count_entryes += 1;
    }else{
      objArray.push(lista_pagamentos)
    }
  }
  $("#payment_list").append(`<p><u>Os ${count_entryes} códigos de nota anteriores não serão dados como pagos</u><p>`);

  numbers_as_payed = objArray.length;

  for (i=0; i<objArray.length;i++){
    
    $.get({
      url: "setting/payment_date_exists?number=" + objArray[i].codigo+ "&date=" + objArray[i].data + "&date_payment=" + objArray[i].data_pagamento ,
      dataType: "text",
      success: function (data) {
        if (data){
          $("#payment_list").append(data);
        }
      }
    })
    if(objArray.length-1 == i){
      $("#payment_list").append(`<p><u>Os ${objArray.length} códigos de nota a seguir são de aprovações e serão dados como pagos se encontrados:</u></p>`);
    }
  }
}

function fillModalEditNote(number){
  number = number ? number : $("#number_edit").val();
  $("#number_edit").val(number);
  $("#payment_div_edit").html('');  

  $.get({
    url: "setting/getNote?number=" + number,
    dataType: "text",
    success: function (data) {
      if (data){
        result = JSON.parse(data)
        $("#emiter_edit").val(result[0].emiter)
        $("#payment_note_id_edit").val(result[0].note_id)
        $("#payment_id_edit").val(result[0].payment_id)
        $("#destine_edit").val(result[0].destine)
        $("#payment_method_edit").val(result[0].method)
        $("#observation_edit").val(result[0].observation)
        $("#selected_account_edit").val(result[0].id_account)
  
        $('#income_edit').find(":selected").attr("selected",false);
        $(`#income_edit [value=${result[0].income}]`).attr("selected",true)
  
        i=0;
        for(i=0; i < result.length; i++){
          $("#payment_div_edit").append(`
          <div class="row col-10">
          <input name="id_note[]" type="text" class="form-control" value="${result[i].payment_id}" hidden>
          <input name="parcel_date[]" type="date" class="form-control col-5" value="${result[i].parcel_date}">
          <input name="parcel_value[]" type="text" class="form-control col-5" value="${result[i].parcel_value}">
          </div><br>`)
        }
      }else{
        alert("Nota não encontrada.");
      }
    }
  })
}

function fillModalEditPayment(id){
  $.get({
    url: "setting/getPayment?id=" + id,
    dataType: "text",
    success: function (data) {
      if (data){
        result = JSON.parse(data)
        $("#id_edit_payment").val(id)
        $("#number_edit_payment").val(result[0].number)
        $("#value_edit_payment").val(result[0].parcel_value)
        $("#date_edit_payment").val(result[0].parcel_date)
        $("#payment_status_edit_payment").val(result[0].status_code)
        if(result[0].status_code == 1){
          $("#date_approved_edit_payment").prop('required',true);
          $("#date_approved_edit_payment").removeAttr('readonly');
        }else{
          $("#date_approved_edit_payment").attr('readonly',true);
          $("#date_approved_edit_payment").prop('required',true);
        }
        $("#date_approved_edit_payment").val(result[0].approved_date)
      }else{
        alert("Pagamento não encontrado.")
      }
     
    }}
  )
}

function fill_modal_edit_login(id,name,user,password,sistem){
  console.log(id,name,user,password,sistem);
  $("#edit_login_id").val(id)
  $("#edit_login_name").val(name)
  $("#edit_login_user").val(user)
  $("#edit_login_pasword").val(password)
  $("#edit_login_sistem").val(sistem)
}

function delete_account(event){
  $(event.target).remove();
  get_chart_values_to_receive();
  get_chart_values_received();
  get_defaulters();
}

lista_meses = ["","Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]


function add_account_to_filter(event){
  value =$(event.target).val();
  text = $(event.target).find(':selected').text();
  $("#selected_accounts").append(`
  <div onclick="delete_account(event)" 
  class="btn btn-secondary" style=" margin:2px;" 
  value="${value}"> ${text} X 
  </div>
  `);
  get_chart_values_to_receive();
  get_chart_values_received();
  get_defaulters();
}

//Pegar dados que vão preencher os dados do "A receber"
function get_chart_values_to_receive(){
  year = $("#select_year").val() | new Date().getFullYear();
  companies = [];
  if(!$('#selected_accounts').length){return;}
  $('#selected_accounts').children().each(function(){
    companies.push($(this).attr('value'))
  });

  $.post("setting/parcel_values_to_receive",
  {year: year, companies:companies}, 
  function(data){
    $("#table_to_receive").html('');
    aux_array = [''],
    result = JSON.parse(data);

    complete_array = [];
    complete_array.push(['Mes', 'Receber', 'Pagar']);
    for(let i = 0; i< result.length; i++){


      $("#table_to_receive").append(`
        <tr >
          <td class="">${result[i].year}/${lista_meses[result[i].month]}</td>
          <td>${result[i].to_receive ? formatToPrice(result[i].to_receive) : '-'}</td>
          <td class="provision-edit" onkeyup="calculateProvision(event,'${result[i].year}-${result[i].month}')" contenteditable="true" onfocus="clean_provision(event)"
          >${result[i].balcony_prevision ? formatToPrice(result[i].balcony_prevision) : '-'}</td>
          <td class="late">${result[i].expense_value ? formatToPrice(result[i].expense_value) : '-'}</td>
          <td class="${result[i].delayed_to_receive ? 'late' : ''}">${result[i].delayed_to_receive ? formatToPrice(result[i].delayed_to_receive) : '-'}</td>
          <td>${result[i].to_pay ? formatToPrice(result[i].to_pay) : '-'}</td>
          <td onclick="redirect_payment_details('${result[i].month}', '${result[i].year}')" style="cursor:pointer" class="result_line" 
          data-original-value="${formatToPrice(result[i].to_receive - result[i].to_pay + Number(result[i].delayed_to_receive) - (parseFloat(result[i].expense_value) | 0))}">
          ${formatToPrice(result[i].to_receive - result[i].to_pay - result[i].expense_value + Number(result[i].delayed_to_receive) + Number(result[i].balcony_prevision))}</td>
        </tr>  
      `);
      mes = lista_meses[result[i].month];
      receber = parseInt(result[i].to_receive);
      pagar = parseInt(result[i].to_pay);

      complete_array.push([mes, receber, pagar]);
    }
    get_final_total_row();
    //drawChart(complete_array);
    drawVisualization(complete_array);
  })
}

function get_final_total_row(){
  //Pegar dados que vão preencher o somatório a receber
  $.post("setting/parcel_values_to_receive_all_time",
  {year: year, companies:companies}, 
  function(data){
    result = JSON.parse(data);
    for(let i = 0; i< result.length; i++){
      $("#table_to_receive").append(`
      <tr>
        <td>Total:</td>
        <td class="to_receive_all_time">${result[i].expense_value ? formatToPrice(result[i].to_receive_all_time) : '-'}</td>
        <td class="prevision_all_time">${result[i].prevision_all_time ? formatToPrice(result[i].prevision_all_time) : '-'}</td>
        <td class="expense_all_time late">${result[i].expense_value ? formatToPrice(result[i].expense_value): '-'}</td>
        <td class="delay_all_time ${result[i].delayed_to_receive ? 'late' : ''}">${result[i].delayed_to_receive ? formatToPrice(result[i].delayed_to_receive): '-'}</td>
        <td class="to_pay_all_time">${result[i].to_pay_all_time ? formatToPrice(result[i].to_pay_all_time): '-'}</td>
        <td style="cursor:pointer; font-weight:bold;" onclick="redirect_payment_details('${result[i].month}', '${result[i].year}')" 
        class="result_all_time ${(result[i].to_receive_all_time - result[i].to_pay_all_time - result[i].expense_value + Number(result[i].delayed_to_receive) + Number(result[i].prevision_all_time)) < 0 ? 'late' : 'positive'} final_total_value"
        data-original-value=${result[i].to_receive_all_time - result[i].to_pay_all_time - result[i].expense_value + Number(result[i].delayed_to_receive) + Number(result[i].prevision_all_time)} >
        ${formatToPrice(result[i].to_receive_all_time - result[i].to_pay_all_time - result[i].expense_value + Number(result[i].delayed_to_receive) + Number(result[i].prevision_all_time))}
        </td>
      </tr>  
      `);

    }
  })
}

function get_chart_values_received(){
  
  year = $("#select_year").val() | new Date().getFullYear();
  companies = [];
  
  if(!$('#selected_accounts').length){return;}
  $('#selected_accounts').children().each(function(){
    companies.push($(this).attr('value'))
  });

  //Pegar dados que vão preencher a tabel a receber
  $.post("setting/parcel_values_received",
  {year: year, companies:companies}, 
  function(data){
    $("#table_received").html('');
    aux_array = [''],
    result = JSON.parse(data);

    complete_array = [];
    complete_array.push(['Mes', 'Receber', 'Pagar']);
    for(let i = 0; i< result.length; i++){
      item = result[i];
      const resultPrice = Number(item.to_receive) - Number(item.to_pay) - Number(item.expense_value) + Number(item.balcony_value);
      $("#table_received").append(`
      <tr class="clickable-row" style="cursor:pointer" onclick="redirect_payment_details('${item.month}', '${item.year}')">
        <td>${item.year}/${lista_meses[item.month]}</td>
        <td>${item.to_receive ? (parseFloat(item.to_receive).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '-'}</td>
        <td>${item.balcony_value ? (parseFloat(item.balcony_value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")) : '-'}</td>
        <td class="late">${item.expense_value ? parseFloat(item.expense_value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
        <td>${item.to_pay ? parseFloat(item.to_pay).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '-'}</td>
        <td class="${resultPrice < 0 ? 'late' : ''}">${resultPrice != 0 ? formatToPrice(resultPrice) : '-'}</td>
      </tr>  
      `);

      mes = lista_meses[result[i].month];
      receber = parseInt(result[i].to_receive);
      pagar = parseInt(result[i].to_pay);

      complete_array.push([mes, receber, pagar]);
    }
    /*console.log(complete_array);*/
    drawChart2(complete_array);
    drawVisualization2(complete_array);
  })
}

function get_defaulters(){
  companies = [];
  $('#selected_accounts').children().each(function(){
    companies.push($(this).attr('value'))
  });

  $.post("setting/select_defaulters_companies",
  {year: year, companies:companies}, 
  function(data){
    result = JSON.parse(data);
    $("#defaulters_year").html('');
    result.forEach((item,index)=>{
      $("#defaulters_year").append(`
      <span>Ano: ${item.year} - <span class="late">${parseFloat(item.total).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</span></span><br>
      `)
    })
  })
}



function redirect_payment_details(month, year){
  var href = new URL(window.location.href);
  href.searchParams.set('tab', 'view_month');
  href.searchParams.set('month', month);
  href.searchParams.set('year', year);
  window.location.href = href.toString();
}

function submit_account_value(event, id){
  if(event.keyCode===13){
    var inputValue = $(event.target).val();
    $.post("setting/insert_account_value",
    {value: inputValue, id_account:id}, 
    function(data){
      if (data == 200){
        console.log("PASSOU");
        $('.floating-message').text(`Valor de ${inputValue} registrado com sucesso!`);
        $('.floating-message').css('color', 'green');
        $('.floating-message').fadeIn(500, function() {
        setTimeout(function() {
        $('.floating-message').fadeOut(500);
      }, 1500)});
      }else{
        $('.floating-message').text('Houve algum problema. A informação não foi salva.');
        $('.floating-message').css('color', 'red');
        $('.floating-message').fadeIn(500, function() {
        setTimeout(function() {
        $('.floating-message').fadeOut(500);
      }, 1500)})
      }
    })
  }
}

$('.checkbox_selected').change(() => detect_change_bank_accounts())
function detect_change_bank_accounts(){
  const selected = $('.checkbox_selected').filter(':checked').map(function() {
    return {
      checkbox: this,
      value: $(this).closest('.row').find('.value_to_sum').val()
    };
  }).get();
  const sum = selected.reduce((total, element) => total + parseFloat(element.value), 0).toFixed(2);
  $('#sum_bank_values').html(sum)
}


$('.checkbox_selected_history').change(() => detect_change_history_bank_accounts());
function detect_change_history_bank_accounts(){
  console.log("teste");
  const selected = $('.checkbox_selected_history').filter(':checked').map(function() {
    return {
      checkbox: this,
      value: $(this).closest('.row').find('.value_to_sum').val()
    };
  }).get();
  const sum = selected.reduce((total, element) => total + parseFloat(element.value), 0).toFixed(2);
  $('#sum_bank_values_history').html(parseFloat(sum).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}


function change_payment_spaces(isAdd,divId){
  if(isAdd){
    $('#'+divId).append(`<div class="row col-12">
    <input name="parcel_date[]" type="date" class="form-control col-5">
    <input name="parcel_value[]" type="text" class="form-control col-5" placeholder="Valor">
    </div>`);
  }else{
    $('#'+divId+' div:last').remove();
  }
}

function change_payment_spaces_edit_form(isAdd,divId){
  id_payment = $("#payment_id_edit").val();
  if(id_payment){
    if(isAdd){
      $('#'+divId).append(`<div class="row col-10">
      <input name="parcel_date[]" type="date" class="form-control col-5">
      <input name="parcel_value[]" type="text" class="form-control col-5" placeholder="Valor">
      </div>`);
    }else{
      $('#'+divId+' div:last').remove();
    }
  }else{
    alert("Digite o número da nota antes")
  }
}

function show_history_account_value(){
  date = $("#date_see_account_payments").val();
  $("#list-account-values_history").html('');

  $.get({
    url: "setting/get_history_hands_value_date?date=" + date,
    dataType: "text",
    success: function (data) {
      hands_value = JSON.parse(data);
      continue_(hands_value);
    }})

    function continue_(hands_value){
      $.get({
        url: "setting/get_history_account_values_date?date=" + date,
        dataType: "text",
        success: function (data) {
          result = JSON.parse(data);
          registro = '';
          result.forEach((element,index) => { 
            registro += '<hr> <h6>Data: ' + element[index].date + '</h6>';
            registro += '<h7>Usuário: ' + element[index].user_email + '<h7><br><br>';
            element.forEach((item,index2) => {
              registro += `<p>Conta: ${item.name} - Valor: ${item.value}</p>`
            })
            registro += 'Cartão Antecipação | Em mãos |<br>'
            hands_value.forEach((value,key) => {
              registro += ` ${hands_value[index][key].value} |`
            })
          })
          $("#list-account-values_history").append(
            `<div>
              ${registro}
            <hr>    
            </div>`
          );
        }}
      )
    }
}

function clean_ret_modal(){
  $("#payment_list").html('');
}

function change_date_payment_required(event){
  // Se o estado de pagamento for pra pago, é necessário colocar a data de pagamento
  if($(event.target).val() == 1){
    $("#date_approved_edit_payment").prop('required',true);
    $("#date_approved_edit_payment").removeAttr('readonly');
  }else{
    $("#date_approved_edit_payment").removeAttr('required');
    $("#date_approved_edit_payment").attr('readonly',true);
    $("#date_approved_edit_payment").val('');
  }  
}

function download_table_to_excel(id,nome_arquivo){
  $("#"+id).table2excel({
    filename: nome_arquivo,
});
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart(array) {
  if(!$.isArray(array)){return;}
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    curveType: 'function',
    legend: { position: 'bottom' }
    };
    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
    }

function drawVisualization(array) {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    hAxis: {title: 'Mês'},
    seriesType: 'bars',
    series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
function drawChart2(array) {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    hAxis: {title: 'Mês'},
    seriesType: 'bars',
    series: {5: {type: 'line'}}
    };
    var chart = new google.visualization.ComboChart(document.getElementById('curve_chart2'));
    chart.draw(data, options);
}
function drawVisualization2(array) {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    hAxis: {title: 'Mês'},
    seriesType: 'bars',
    series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
    chart.draw(data, options);
}

function clean_provision(e){
  value = $($(e.target)[0]).text();
  if(value == '-'){$($(e.target)[0]).text('')};

  
}

/*function calculateProvision(event) {
  // Get the value of the updated element
  var updatedValue = event.target.innerText;
  // Check if the input is empty
  if (updatedValue === "") {
    // Get the nearest parent tr element
    var parentRow = $(event.target).closest("tr");
    // Get the result_line element within the parent tr element
    var resultLine = parentRow.find(".result_line");
    // Get the original value of the result_line element
    var originalValue = parseFloat(resultLine.data("original-value"));
    // Set the original value as the text of the result_line element
    resultLine.text(originalValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    return;
  }
  // Convert the value to a number
  updatedValue = parseFloat(updatedValue);

  // Get the nearest parent tr element
  var parentRow = $(event.target).closest("tr");
  // Get the result_line element within the parent tr element
  var resultLine = parentRow.find(".result_line");

  // Get the original value of the result_line element
  var originalValue = parseFloat(resultLine.data("original-value"));

  // Add the updated value to the original value
  var newValue = originalValue + updatedValue;
  // Set the new value as the text of the result_line element
  resultLine.text(newValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}*/
let timerId = null;
function calculateProvision(event, date) {
  var updatedValue = event.target.innerText;

  var parentRow = $(event.target).closest("tr");
  var resultLine = parentRow.find(".result_line");

  if(updatedValue === "-"){
    var originalValue = formatToFloat(resultLine.data("original-value"));
    resultLine.text(formatToPrice(originalValue));
    return;
  }
  
  let updatedNewValue = formatToFloat(updatedValue); 
  var originalValue = formatToFloat(resultLine.data("original-value"));
  var newValue = originalValue + updatedNewValue;
  resultLine.text(formatToPrice(newValue));

  if(updatedValue == ''){
    resultLine.text(formatToPrice(originalValue));
  }

  //Pegando as contas selecionadas
  let accounts = [];
  if(!$('#selected_accounts').length){return;}
  $('#selected_accounts').children().each(function(){
    accounts.push($(this).attr('value'))
  });
  accounts = accounts.sort((a, b) => a - b).join(',')

  let [year, month] = date.split("-");
  month = month.padStart(2, "0");
  let transformedDate = year + "-" + month + "-01";

  if (timerId !== null) {
    clearTimeout(timerId);
  }

  timerId = setTimeout(() => {
    $.post("setting/save_prevision",
      {updatedValue: formatToFloat(updatedValue), date: transformedDate, accounts:accounts}, 
      function(result) {
        if (result) {
          display_message("Salvo com sucesso!", true);
        } else {
          display_message("Houve algum problema com a operação.", false);
        }
      }
    );
  }, 500);
    
  let total_prevision = 0;
  $(".provision-edit").each(function(key,element) {
    text = $(element).text();

    if (text === "" || text === "-") {
      $(".prevision_all_time").text('-')
    }else{
      console.log(text);
      total_prevision = total_prevision + formatToFloat(text);
    }
  });
  $(".prevision_all_time").text(formatToPrice(total_prevision))

  to_receive_all_time = formatToFloat($(".to_receive_all_time").text())
  prevision_all_time = formatToFloat($(".prevision_all_time").text())
  expense_all_time = formatToFloat($(".expense_all_time").text())
  delay_all_time = formatToFloat($(".delay_all_time").text())
  to_pay_all_time = formatToFloat($(".to_pay_all_time").text())
  result_all_time = formatToFloat($(".result_all_time").text())

  result = to_receive_all_time + prevision_all_time - expense_all_time + delay_all_time - to_pay_all_time
  $(".result_all_time").text(formatToPrice(result))

}

function get_recents_notes(income){
  $("#modal-body-see-recents").html('');
  $.get({
    url: "setting/get_recents_notes?income=" + income,
    dataType: "text",
    success: function (data) {
      result = JSON.parse(data).data;
      result.forEach((element,index) => { 
        $("#modal-body-see-recents").append(
          `<tr>
            <td>${element.number}</td>
            <td>${formatToPrice(element.parcel_value)}</td>
            <td>${element.parcel_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1")}</td>
            <td>${element.account}</td>
            <td>${element.emiter}</td>
            <td>${element.destine}</td>
            <td>${element.status}</td>
          </tr>`
        );
      })
    }}
  )
}




function formatToPrice(double){
  return Number(double).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})
}

function formatToFloat(real){
  return parseFloat(real.replace(/\./g, '').replace(',', '.'));
}


function display_message(message,isSuccess){
  if (isSuccess){
      $('.floating-message').text(message);
      $('.floating-message').css('color', 'green');
      $('.floating-message').fadeIn(500, function() {
      setTimeout(function() {
      $('.floating-message').fadeOut(500);
    }, 1500)});
    }else{
      $('.floating-message').text(message);
      $('.floating-message').css('color', 'red');
      $('.floating-message').fadeIn(500, function() {
      setTimeout(function() {
      $('.floating-message').fadeOut(500);
    }, 1500)})
  }
}

/*
function calculateProvision(e){
  value = $($(e.target)[0]).text();
  value = value.replace(/[.,]/g, "");
  value = value.slice(0, -2) + "." + value.slice(-2);
  console.log(value);
}*/

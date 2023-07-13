const ModalContato = {
    props: ['contato'],
    data() {
        return {
            showForm: false,
            imovel: null,
            formContato: {
                nome: '',
                telefone: '',
                email: '',
                mensagem: '',
            }
        }
    },

    mounted() {

        const modalContato = document.getElementById('modalContato')
        modalContato.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const recipient = JSON.parse(button.getAttribute('data-bs-whatever'));

            this.imovel = recipient.imovel;
            this.showForm = recipient.showForm;


            this.formContato.mensagem = 'Olá, Gostaria de ter mais informações sobre o imóvel '
                + this.imovel.imovel_titulo + ' código: ' + this.imovel.imovel_ref + ' que encontrei no seu site. Aguardo seu contato, obrigado.';

            setTimeout(() => {
                $('.phone_mask').mask('(00) 00000-0000');
            }, 500);
        })

    },

    methods: {
        async sendContact() {
            $(".btn-send-contact").html("<i class='fa fa-refresh spin'></i> Enviando")
            var toastSuccess = new bootstrap.Toast(document.getElementById('toastSucceess'));
            var toastError = new bootstrap.Toast(document.getElementById('toastErroor'));
            if (!this.formContato.nome || !this.formContato.telefone || !this.formContato.email || !this.formContato.mensagem) {
                this.error = 'Todos os campos são obrigatórios!';
                return toastError.show();
            }
            try {

                var form = new FormData();

                form.append('nome', this.formContato.nome);
                form.append('telefone', this.formContato.telefone);
                form.append('email', this.formContato.email);
                form.append('mensagem', this.formContato.mensagem);
                form.append('imovel_id', this.imovel.imovel_id);

                const response = await axios.post('${baseUri}/imovel/sendContact', form);


                if (response.status == 200) {
                    toastSuccess.show();
                    $(".btn-send-contact").html("Enviar")
                }

            } catch (error) {
                console.error(error);
                $(".btn-send-contact").html("Enviar")

            }

            $('#button_closee-modal').trigger('click')
        },
    },

    template: `
    <div>
    <div class="modal fade" :id="'modalContato'" tabindex="-1" :aria-labelledby="'modalContato'" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" :id="'modalContato'">Entre em contato</h1>
                    <button type="button" class="btn-close" :id="'button_closee-modal'" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-show="showForm">
                        <div class="text-center" v-if="contato">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>
                            &nbsp;
                            <span v-text="contato.config_site_telefone"></span>
                            &nbsp;
                            &#8226;
                            &nbsp;

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path
                                    d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                            </svg>
                            &nbsp;
                            <span v-text="contato.config_site_telefone2"></span>
                            <br>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                            </svg>&nbsp;
                            <span v-text="contato.config_site_email"></span>
                        </div>


                        <div class="row pt-4">
                            <hr>

                            <div class="col-12 mt-2">

                                <input type="text" v-model="formContato.nome" class="form-control" id="contato_nome"
                                    placeholder="Seu nome">
                            </div>
                            <div class="col-12 mt-2">

                                <input type="tel" class="form-control phone_mask" v-model="formContato.telefone"
                                    id="contato_telefone" placeholder="Seu telefone">

                            </div>

                            <div class="col-12 mt-2">

                                <input type="email" class="form-control" v-model="formContato.email" id="contato_email"
                                    placeholder="Seu email">

                            </div>

                            <div class="col-12 mt-2">
                                <textarea class="form-control" id="contato_mensagem" v-model="formContato.mensagem"
                                    rows="3"></textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-send-contact" @click="sendContact"
                                        type="button">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="!showForm">

                        <div class="container" v-if="contato">
    
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>&nbsp;
                                    <span v-text="contato.config_site_telefone"></span>
                                </li>
                                <li class="list-group-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path
                                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                    </svg>
                                    &nbsp;
                                    <span v-text="contato.config_site_telefone2"></span>
                                </li>
    
    
                                <li class="list-group-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                                    </svg>
                                    &nbsp;
                                    <span v-text="contato.config_site_email"></span>
                                </li>
    
                            </ul>
                        </div>
                    </div>
                </div>


               
            </div>
        </div>
    </div>
    <div class="toast text-bg-primary border-0 justify-content-center align-items-center  mx-auto " role="alert"
        aria-live="assertive" aria-atomic="true" id="toastSucceess">
        <div class="d-flex">
            <div class="toast-body">
                Mensagem enviada com sucesso! Em breve entraremos em contato!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
    <div class="toast text-bg-danger border-0 justify-content-center align-items-center  mx-auto " role="alert"
        aria-live="assertive" aria-atomic="true" id="toastErroor">
        <div class="d-flex">
            <div class="toast-body">
                {{error}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>`
}
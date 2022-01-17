<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produtos extends MY_Controller
{

    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('produtos_model');
        $this->data['menuProdutos'] = 'Produtos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    private function handle_form_error() {
        return [
            'codDeBarra' => form_error('codDeBarra', null, null),
            'descricao' => form_error('descricao', null, null),
            'unidade' => form_error('unidade', null, null),
            'precoCompra' => form_error('precoCompra', null, null),
            'precoVenda' => form_error('precoVenda', null, null),
            'estoque' => form_error('estoque', null, null),
            'estoqueMinimo' => form_error('estoqueMinimo', null, null),
            'saida' => form_error('saida', null, null),
            'entrada' => form_error('entrada', null, null)
        ];
    }

    public function gerenciar()
    {
        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('produtos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->produtos_model->count('produtos');

        $this->pagination->initialize($this->data['configuration']);
        $data = $this->produtos_model->get('produtos', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));
        $this->data['results'] = $data;

        $this->data['view'] = 'produtos/produtos';
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode($data));
    }

    public function adicionar()
    {
        $_POST = json_decode($this->input->raw_input_stream, true);
        $this->load->library('form_validation');
        $result;
        if ($this->form_validation->run('produtos') == false) {
            $result = $this->handle_form_error();
        } else {
            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(",", "", $precoCompra);
            $precoVenda = $this->input->post('precoVenda');
            $precoVenda = str_replace(",", "", $precoVenda);
            $data = [
                'codDeBarra' => set_value('codDeBarra'),
                'descricao' => set_value('descricao'),
                'unidade' => set_value('unidade'),
                'precoCompra' => $precoCompra,
                'precoVenda' => $precoVenda,
                'estoque' => set_value('estoque'),
                'estoqueMinimo' => set_value('estoqueMinimo'),
                'saida' => set_value('saida'),
                'entrada' => set_value('entrada'),
            ];
            $insertId = $this->produtos_model->add('produtos', $data);
            $result = $this->produtos_model->getById($insertId);
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['message' => 'id inválido']));
        }

        $_POST = json_decode($this->input->raw_input_stream, true);
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtosUpdate') == false) {
            $result = $this->handle_form_error();
        } else {
            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(",", "", $precoCompra);
            $precoVenda = $this->input->post('precoVenda');
            $precoVenda = str_replace(",", "", $precoVenda);
            $data = array_filter([
                'codDeBarra' => set_value('codDeBarra'),
                'descricao' => $this->input->post('descricao'),
                'unidade' => $this->input->post('unidade'),
                'precoCompra' => $precoCompra,
                'precoVenda' => $precoVenda,
                'estoque' => $this->input->post('estoque'),
                'estoqueMinimo' => $this->input->post('estoqueMinimo'),
                'saida' => set_value('saida'),
                'entrada' => set_value('entrada'),
            ]);
            $result = $this->produtos_model->edit('produtos', $data, 'idProdutos', $this->uri->segment(3));
            if (!$result) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(404)
                    ->set_output(json_encode(['message' => 'produto não encontrado']));
            }
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['message' => 'id inválido']));
        }

        $result = $this->produtos_model->getById($this->uri->segment(3));

        if (!$result) {
            return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(404)
                    ->set_output(json_encode(['message' => 'Produto não encontrado']));
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($result));
    }

    public function excluir()
    {
        $_POST = json_decode($this->input->raw_input_stream, true);
        $id = $this->input->post('id');
        if ($id == null) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['message' => 'id não encontrado']));
        }

        $this->produtos_model->delete('produtos_os', 'produtos_id', $id);
        $this->produtos_model->delete('itens_de_vendas', 'produtos_id', $id);
        $this->produtos_model->delete('produtos', 'idProdutos', $id);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(['message' => 'produto excluido']));
    }
}

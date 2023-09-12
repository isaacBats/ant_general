<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fun extends CI_Controller {
	function cat_orden(){
		$this->load->model('Category_model');
		$post=$this->input->post('id');
		$i=0;
		$ord=array();
		foreach($post as $id=>$val){
			$ord['orden']=$i++;
			$ord['parent_id']=(int)$val;
			$this->Category_model->orden($id, $ord);
		}
	}
	function _slug($post,$id=false){
		$this->load->helper('text');

		$slug['slug']=url_title(convert_accented_characters($post['name']), 'dash', true);
		$slug['slug']=$this->Route_model->validate_slug($slug['slug'],$post['route_id']);

		if($id)
			$this->db->update($this->table,$post,array('id'=>$id));
		else{
			$this->db->insert($this->table,$post);
			$post['route_id']=$this->db->insert_id();
		} 

		$slug['route']=$this->slug.'/'.$id;
		$this->Route_model->save($slug,$post['route_id']);
		return true;

	}
	function _del_slug($id){
		$route_id=$this->db->where('id',$id)->get($this->table)->row()->route_id;
		$this->db->where('id', $route_id)->delete(DB.'routes');
	}
	function _display_categories($cats, $layer='', $first='') {
		$this->cont.=$first ? '<ol'.$first.'>' : '';
		//print_r($cats);
		foreach ($cats as $cat){
			$c=$cat['category'];
			$this->cont.='<li id="id_'.$c->id.'">
			<div class="li">
				<span class="gc_order_delete">'.$c->name.'</span>
				<div class="gc_cell_right" style="float:right">
					<a href="'.site_url($this->adm.'/crud/categorias/edit/'.$c->id).'" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
						<span class="ui-button-text">&nbsp;Editar</span>
					</a>
					<a onclick = "javascript: return delete_li(\''.site_url($this->adm.'/crud/categorias/delete/'.$c->id).'\', \''.$c->id.'\')"
						href="#" class="delete_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-circle-minus"></span>
						<span class="ui-button-text">&nbsp;Borrar</span>
					</a>
				</div><br style="clear:both"/>
			</div>';
		if (sizeof($cat['children']) > 0)
			if($layer == 1){
				$next = $layer+1;
				$this->_display_categories($cat['children'], $next, ' class="rl"');
			}else{
				$next = $layer+1;
				$this->_display_categories($cat['children'], $next, ' class="nav"');
			}
		$this->cont.= '</li>';
		}
		$this->cont.= $first ? '</ol>' : '';
		return $this->cont;
	}
	private function _tab($head=array(),$sq='',$id=array(),$url='',$sort=false){

		$tb='<table class="gc_table"><thead><tr>';
		$head[]='';
		for ($i=0; $i <count($head) ; $i++) {
			$cl=$i==0 ? 'gc_cell_left' : '';
			$cl=$i==(count($head)-1) ? 'gc_cell_right' : '';
			$tb.='<th class="'.$cl.'">'.$head[$i].'</th>';
		}
		$tb.='</thead></tr>';
		$tb.='<tbody '.($sort ? 'id="banners_sortable"' : '').'>';
		foreach($sq as $x){
			$tb.='<tr id="orden-'.$x->id.'">';
				foreach($id as $i)
					$tb.='<td>'.$x->$i.'</td>';

			$tb.='<td class="gc_cell_right list_buttons">
					<a href="'.site_url($url.'/delete/'.$x->id).'" class="del">Borrar</a>
					<a href="'.site_url($url.'/edit/'.$x->id).'">Editar</a>
				</td></tr>';
		}

		$tb.='</tbody>';


		$tb.='</table>';

		return $tb;
	}
	private function _add($tb='',$title='',$url='',$tab=''){
		$tb='<div class="datatables-add-button"><a role="button" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" href="'.site_url($url.'/add').'"><span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span><span class="ui-button-text">Agregar '.$title.'</span></a></div><br/>'.$tb;
		$js=array(
				site_url('assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.8.23.custom.min.js'),
				site_url('assets/grocery_crud/themes/datatables/js/datatables.js')
				);
		if(trim($tab)) $js[]=site_url().'assetsdm/js/sort.js?url='.site_url('admin/crud/sort/').$tab;
		$css=array(
				site_url('assets/grocery_crud/css/ui/simple/jquery-ui-1.8.23.custom.css')
			);
		return $this->_out($tb,$js,$css);
	}
	private function _menu($id){
		$this->db = $this->load->database('default',TRUE);
		$ret='';
		$menu=$this->db->select(DB.'menu.*')->where('id_user',$id)->join(DB.'menu','id=id_menu')->order_by('priority','ASC')->get(DB.'user_perm')->result();

		$men=array();
		foreach($menu as $m)
			$men[$m->parent][]=(object)array('url'=>$m->url,'name'=>$m->name);
		ksort($men);

		if(count($men)>0)
			foreach($men as $id=>$m){
				foreach($this->db->select('name')->where('id',$id)->get(DB.'menu')->result() as $title);
				$ret.='<div class="menu shadow"><div class="menu_title">'.$title->name.'</div>';
				foreach($m as $u)
					$ret.='<a href="'.site_url($this->adm.'/crud/'.$u->url).'">'.$u->name.'</a>';
				$ret.='</div>';
			}

		return $ret;
	}
	private function _out($out='',$js=array(),$css=array()){
		return (object)array('output' => $out , 'js_files' => $js , 'css_files' => $css);
	}
	function tpl($con,$title='',$extra=''){
		$js='';$css='';
		foreach($con->js_files as $j)
			$js.='<script type="text/javascript" src="'.$j.'"></script>';
		foreach($con->css_files as $c)
			$css.='<link rel="stylesheet" href="'.$c.'"/>';

		$data=array('CONTAINER' =>$extra.$con->output,
					'MENU'		=>$this->_menu($this->id),
					'CSS'       =>$css,
					'JS'        =>$js,
					'DIR'       =>site_url('assetsdm'),
					'BASE'		=>site_url(),
					'TITLE'		=>$title
					);
		echo $this->parser->parse('adm/body_index.html',$data,true);
	}
	function _call_upload($uploader_response,$field_info, $files_to_upload){
		$img=array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
		
		if(in_array($uploader_response[0]->type, $img)){
			$this->load->library('image_moo');

			$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;

			$w=(int)$this->img_w>0 ? $this->img_w : 100;
			$h=(int)$this->img_h>0 ? $this->img_h : 100;
			
			list($width, $height, $type, $attr) = getimagesize($file_uploaded);

			if($w==$width && $h==$height){
				$this->image_moo->load($file_uploaded)->resize($w,$h)->save($file_uploaded,true);
				return true;
			}else{
				unlink($file_uploaded);
				return 'Debe tener el tamaño de '.$w.'px x '.$h.'px';
			}
		}
	}
	function _adm_pass($post,$id){
		if($this->db->where('id',$id)->where('pass',$post['pass'])->count_all_results(DB.'user')==0)
			$post['pass']=md5($post['pass']);
		return $post;
	}
}

/* End of file fun.php */
/* Location: ./application/controllers/panelabc12/fun.php */

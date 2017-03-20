function activity_validate() {
	var title = form.title;
	var courses = document.getElementsByName('courses[]');
	var centers = document.getElementsByName('centers[]');

	var count_checked = 0;
	for (var i = 0; i<courses.length; i++) {
		if(courses[i].checked) {
			count_checked++;
		}
	}
	for (var i = 0; i<centers.length; i++) {
		if(centers[i].checked) {
			count_checked++;
		}
	}

	var objective = form.objective;
	var goals = form.goals;
	var future_goals = form.future_goals;
	var year = form.year;

	if(!title.value) {
		swal("Erro", "Por favor, preencha o nome da atividade!");
		return false;
	}

	if(count_checked==0) {
		swal("Erro", "Pelo menos um curso ou centro deve ser selecionado!");
		return false;
	}

	if(!objective.value) {
		swal("Erro", "Por favor, preencha o campo Objetivos!");
		return false;
	}

	if(!goals.value) {
		swal("Erro", "Por favor, preencha o campo Metas Alcançadas!");
		return false;
	}

	if(!future_goals.value) {
		swal("Erro", "Por favor, preencha o campo Metas Futuras!");
		return false;
	}

	if(!year.value) {
		swal("Erro", "Por favor, preencha o ano de execução!");
		return false;
	} else {
		var reg = /^\d{4}$/;
		if(!reg.test(year.value)) {
			swal("Erro", "O ano inserido não é válido");
			return false;
		}
	}
}

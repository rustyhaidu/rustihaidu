import java.util.*;


public class Machine {
	Money[] array_de_money = new Money[10];
	Recipe[] recipes = new Recipe[10];
	
	
	public static ArrayList<Produs> total_produse =new ArrayList<Produs>();
	
	static void add_produse_to_the_vending_machine(Produs produs)
	{
		//ArrayList<String> total_ingredients_list =new ArrayList<String>();
		//total_ingredients.add(id).add(ingredient);
		//total_ingredients_list.add(ingredient);
		
		Machine.total_produse.add(produs);
	}
	ArrayList<Produs>  get_produse ()
	{
		return Machine.total_produse;
	}
	static void comanda(Recipe recipe)
	{
		for (int i=0;i<total_produse.size();i++)
		{
			if (total_produse.get(i).id == recipe.id)
			{
				System.out.println("A fost comandat produsul "+total_produse.get(i).nume);
				total_produse.remove(i);				
			}
		}
	}
	
	public static void main(String[] args){
		Produs prod1 = new Produs("cireasa",3,1);
		Produs prod2 = new Produs("pruna",2,1);
				
		add_produse_to_the_vending_machine(prod1);
		add_produse_to_the_vending_machine(prod2);
		
		Money suma1 = new Money();
		suma1.add_to_total(5);
		suma1.add_to_total(10);
		
		System.out.println(suma1.get_total());
		
		Recipe comanda1 =new Recipe(1,suma1.get_total());
		comanda(comanda1);
		
		System.out.println(prod1.price);
		int change = suma1.total_sum - prod1.price;
		System.out.println("Ti-au mai ramas "+change+" unitati");
		//System.out.println(total_produse.get(1).nume);
		
		//System.out.println(suma1.add_to_total(10));
		
		
	}
}
//in loc de 4 , trebuie introdus obiect de tip money

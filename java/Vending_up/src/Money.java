import java.util.*;
public class Money {
	int accepted_money[] = {1,5,10,15};
	public int total_sum;
	 //ArrayList S = new ArrayList();
	 
	public Money()
	{
		
	}
	void add_to_total(int money)
	{
		ArrayList<Integer> total_money = new ArrayList<Integer>();
		for (int i=0;i<this.accepted_money.length;i++)
		{
			//parcurg valorile introduse sa coincida cu accepted values
			if (money == this.accepted_money[i])
			{
				total_money.add(money);
			}
		}
		//calculez suma valorilor acceptate
		for (int i=0;i<total_money.size();i++)
		{
			this.total_sum = this.total_sum + total_money.get(i);
		}
		
	}
	int get_total()
	{
		return this.total_sum;
	}
		
}
